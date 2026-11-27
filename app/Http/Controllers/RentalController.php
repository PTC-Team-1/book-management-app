<?php

namespace App\Http\Controllers;

use App\Constants\RentalStatus as ConstantsRentalStatus;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\RentalRequest;
use App\Models\RentalStatus;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{

    //書籍申請
    public function create()
    {
        $rentalRequests = RentalRequest::all();
        $data = [
            'rentalRequests' => $rentalRequests
        ];

        return view('rental-requests.create', $data);
    }

    public function approve(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'rental_request_id' => ['required', 'integer', 'exists:rental_requests,id'],
        ]);

        $rentalRequest = RentalRequest::with('book.rentalStatus')
            ->findOrFail($validatedData['rental_request_id']);

        $book = $rentalRequest->book;

        if (! $book || ! $book->isAvailable()) {
            abort(403);
        }

        $rentedStatusId = RentalStatus::where('code', 'rented')->value('id');

        $book->rental_status_id = $rentedStatusId ?? 2;
        $book->save();

        $rentalRequest->delete();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_APPROVED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        return redirect()->route('admin.books.rentals.request.create');
    }

    public function request(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $rentalRequest = new RentalRequest();
        $rentalRequest->book_id = $validatedData['book_id'];
        $rentalRequest->user_id = $validatedData['user_id'];
        $rentalRequest->save();

        $book = Book::find($validatedData['book_id']);

        $data = [
            'book' => $book
        ];

        return view('rental-requests.complete', $data);
    }

    public function returnForm()
    {
        return view('rental-requests.return-form');
    }

    public function return(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $book = Book::find($validatedData['book_id']);
        $book->rental_status_id = ConstantsRentalStatus::AVAILABLE;
        $book->save();

        $activityLogger->record(
            $request->user()->id,
            ActivityLog::ACTION_RETURNED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        return redirect()
            ->route('admin.books.rentals.return.create')
            ->with('status', '返却処理が完了しました');
    }

    public function returnBatch(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $isbns = $request->input('isbns');
        if (is_array($isbns)) {
            $request->merge([
                'isbns' => array_map(
                    static fn($isbn) => is_string($isbn)
                        ? strtoupper(preg_replace('/[\s-]+/', '', trim($isbn)) ?? '')
                        : $isbn,
                    $isbns
                ),
            ]);
        }

        $validatedData = $request->validate([
            'isbns' => ['required', 'array', 'min:1', 'max:10'],
            'isbns.*' => ['required', 'string', 'max:20', 'regex:/\A(?:\d{13}|\d{9}[\dX])\z/', 'distinct'],
        ], [
            'isbns.required' => '返却する書籍のISBNを読み取ってください。',
            'isbns.min' => '返却する書籍のISBNを読み取ってください。',
            'isbns.max' => '一度に返却できるのは10冊までです。',
            'isbns.*.required' => 'ISBNを入力してください。',
            'isbns.*.regex' => 'ISBNの形式が正しくありません。',
            'isbns.*.distinct' => '同じISBNが一覧に複数あります。',
        ]);

        // DB内のISBN（ハイフン・空白除去）と照合するために全対象ISBNの書籍を取得
        $booksByIsbn = Book::query()
            ->whereNotNull('isbn')
            ->whereRaw(
                "UPPER(REPLACE(REPLACE(isbn, '-', ''), ' ', '')) IN (" . implode(',', array_fill(0, count($validatedData['isbns']), '?')) . ')',
                $validatedData['isbns']
            )
            ->get()
            ->keyBy(static fn(Book $book) => strtoupper(preg_replace('/[\s-]+/', '', (string) $book->isbn) ?? ''));

        $targetBooks = [];

        foreach ($validatedData['isbns'] as $index => $isbn) {
            /** @var Book|null $book */
            $book = $booksByIsbn->get($isbn);

            if (!$book) {
                return back()
                    ->withErrors(["isbns.{$index}" => "ISBN「{$isbn}」の書籍が見つかりません。"])
                    ->withInput();
            }

            if ((int) $book->rental_status_id !== ConstantsRentalStatus::RENTED) {
                return back()
                    ->withErrors(["isbns.{$index}" => "「{$book->title}」は現在貸出中ではありません。"])
                    ->withInput();
            }

            $targetBooks[$index] = $book;
        }

        DB::transaction(function () use ($targetBooks, $request, $activityLogger): void {
            foreach ($targetBooks as $book) {
                $book->rental_status_id = ConstantsRentalStatus::AVAILABLE;
                $book->save();

                // 必要に応じて貸出中レコード（rental_requests 等）を削除または完了状態にする場合
                RentalRequest::query()
                    ->where('book_id', $book->id)
                    ->delete();

                $activityLogger->record(
                    $request->user(),
                    ActivityLog::ACTION_RETURNED ?? 'returned',
                    ActivityLog::SUBJECT_BOOK,
                    $book->id,
                );
            }
        });

        return redirect()
            ->route('admin.books.rentals.return.create')
            ->with('status', count($targetBooks) . '冊を返却しました。');
    }
}
