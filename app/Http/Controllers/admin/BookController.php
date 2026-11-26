<?php

namespace App\Http\Controllers\admin;

use App\Constants\Category as ConstantsCategory;
use App\Constants\RentalStatus;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Services\ActivityLogger;
use App\Services\OpenBdLookupService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories
        ];

        return view('books.create', $data);
    }

    public function store(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'title' => 'required | string | min:1 | max:100',
            'author' => 'nullable | string',
            'publisher' => 'nullable | string',
            'published_date' => 'nullable | date',
            'isbn' => 'nullable | string',
            'description' => 'nullable | string',
            'thumbnail' => 'nullable | string',
            'category_id' => 'nullable | integer',
        ]);

        $book = new Book();
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->publisher = $validatedData['publisher'];
        $book->isbn = $validatedData['isbn'];
        $book->published_date = $validatedData['published_date'];
        $book->description = $validatedData['description'];
        $book->thumbnail = $validatedData['thumbnail'];
        $book->rental_status_id = RentalStatus::AVAILABLE;
        $book->category_id = $validatedData['category_id'] ?? ConstantsCategory::DEFAULT_VALUE;

        $book->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_CREATED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        $data = [
            'book' => $validatedData,
        ];

        return view('books.store', $data);
    }

    public function lookupIsbn(Request $request, OpenBdLookupService $openBdLookupService): JsonResponse
    {
        $rawIsbn = $request->query('isbn');
        $isbn = is_string($rawIsbn)
            ? strtoupper(preg_replace('/[\s-]+/', '', trim($rawIsbn)) ?? '')
            : '';

        $request->merge(['isbn' => $isbn]);
        $validatedData = $request->validate([
            'isbn' => ['required', 'regex:/\A(?:\d{13}|\d{9}[\dX])\z/'],
        ], [
            'isbn.required' => 'ISBNを読み取ってください。',
            'isbn.regex' => 'ISBNを正しく読み取れませんでした。',
        ]);

        try {
            $bookInfo = $openBdLookupService->lookup($validatedData['isbn']);
        } catch (ConnectionException $exception) {
            Log::warning('OpenBD API connection failed.', [
                'exception' => $exception::class,
            ]);

            return response()->json([
                'message' => 'OpenBDに接続できませんでした。時間をおいて再度お試しください。',
            ], 503);
        } catch (RequestException $exception) {
            Log::warning('OpenBD API returned an unsuccessful response.', [
                'status' => $exception->response->status(),
            ]);

            return response()->json([
                'message' => 'OpenBDから書籍情報を取得できませんでした。',
            ], 502);
        }

        if ($bookInfo === null) {
            return response()->json([
                'message' => 'OpenBDに該当する書籍情報が見つかりませんでした。手入力してください。',
            ], 404);
        }

        return response()->json($bookInfo);
    }

    public function storeBatch(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $books = $request->input('books');
        if (is_array($books)) {
            foreach ($books as $index => $book) {
                if (is_array($book) && is_string($book['isbn'] ?? null)) {
                    $books[$index]['isbn'] = strtoupper(preg_replace('/[\s-]+/', '', trim($book['isbn'])) ?? '');
                }
            }

            $request->merge(['books' => $books]);
        }

        $validatedData = $request->validate([
            'books' => ['required', 'array', 'min:1', 'max:10'],
            'books.*' => ['required', 'array'],
            'books.*.isbn' => ['required', 'string', 'max:20', 'regex:/\A(?:\d{13}|\d{9}[\dX])\z/', 'distinct'],
            'books.*.title' => ['required', 'string', 'min:1', 'max:255'],
            'books.*.author' => ['nullable', 'string', 'max:255'],
            'books.*.publisher' => ['nullable', 'string', 'max:255'],
            'books.*.published_date' => ['nullable', 'date'],
            'books.*.description' => ['nullable', 'string'],
            'books.*.thumbnail' => ['nullable', 'url', 'max:255'],
            'category_id' => 'nullable | integer',
        ], [
            'books.required' => '登録する書籍を読み取ってください。',
            'books.min' => '登録する書籍を読み取ってください。',
            'books.max' => '一度に登録できるのは10冊までです。',
            'books.*.isbn.distinct' => '同じISBNが一覧に複数あります。',
            'books.*.title.required' => '書名を入力してください。',
        ]);

        foreach ($validatedData['books'] as $index => $bookData) {
            $existingBook = Book::query()
                ->whereNotNull('isbn')
                ->whereRaw("REPLACE(REPLACE(isbn, '-', ''), ' ', '') = ?", [$bookData['isbn']])
                ->exists();

            if ($existingBook) {
                return back()
                    ->withErrors(["books.{$index}.isbn" => 'このISBNはすでに登録されています。'])
                    ->withInput();
            }
        }

        // 2026年11月25日追加: 一括登録と各書籍の操作履歴を同じトランザクションで保存する。
        DB::transaction(function () use ($validatedData, $request, $activityLogger): void {
            foreach ($validatedData['books'] as $bookData) {
                $book = new Book;
                $book->title = $bookData['title'];
                $book->author = $bookData['author'] ?? null;
                $book->publisher = $bookData['publisher'] ?? null;
                $book->isbn = $bookData['isbn'];
                $book->published_date = $bookData['published_date'] ?? null;
                $book->description = $bookData['description'] ?? null;
                $book->thumbnail = $bookData['thumbnail'] ?? null;
                $book->rental_status_id = RentalStatus::AVAILABLE;
                $book->category_id = $validatedData['category_id'] ?? ConstantsCategory::DEFAULT_VALUE;

                $book->save();

                $activityLogger->record(
                    $request->user(),
                    ActivityLog::ACTION_CREATED,
                    ActivityLog::SUBJECT_BOOK,
                    $book->id,
                );
            }
        });

        return redirect()
            ->route('admin.books.create')
            ->with('active_tab', 'batch')
            ->with('status', count($validatedData['books']) . '冊を登録しました。');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('books.edit');
        }

        $bookId = $request->input('id');
        $bookData = Book::find($bookId);
        $categories = Category::all();

        $data = [
            'book' => $bookData,
            'categories' => $categories
        ];

        return view('books.edit', $data);
    }

    public function update(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => 'required | exists:books,id',
            'title' => 'required | string | min:1 | max:100',
            'author' => 'nullable | string',
            'publisher' => 'nullable | string',
            'published_date' => 'nullable | date',
            'isbn' => 'nullable | string',
            'description' => 'nullable | string',
            'thumbnail' => 'nullable | string',
            'category_id' => 'nullable | integer',
        ]);

        $book = Book::find($validatedData['id']);
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->publisher = $validatedData['publisher'];
        $book->isbn = $validatedData['isbn'];
        $book->published_date = $validatedData['published_date'];
        $book->description = $validatedData['description'];
        $book->thumbnail = $validatedData['thumbnail'];
        $book->category_id = $validatedData['category_id'] ?? ConstantsCategory::DEFAULT_VALUE;

        $book->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_UPDATED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        $data = [
            'book' => $validatedData,
        ];

        return view('books.update', $data);
    }

    public function erase(Request $request)
    {

        if ($request->isMethod('get')) {
            return view('books.erase');
        }

        $bookId = $request->input('id');
        $bookData = Book::find($bookId);
        $data = [
            'book' => $bookData
        ];
        return view('books.erase', $data);
    }

    public function delete(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => 'required | exists:books,id',
        ]);

        $book = Book::find($validatedData['id']);
        $book->delete();
        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_DELETED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        $data = [
            'book' => $book
        ];

        return view('books.delete', $data);
    }
}
