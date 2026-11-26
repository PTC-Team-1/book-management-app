<?php

namespace App\Http\Controllers;

use App\Constants\RentalStatus as ConstantsRentalStatus;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\RentalRequest;
use App\Models\RentalStatus;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function show()
    {
        $rentalRequests = RentalRequest::all();
        $data = [
            'rentalRequests' => $rentalRequests
        ];

        return view('rental-requests.show', $data);
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

        return redirect('/admin/books/rentals/request');
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

        // TODO: フロント側が完成後に追加する
        // return redirect()
        //     ->route('admin.books.rental.index')
        //     ->with('status', '返却処理が完了しました')
    }
}
