<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RentalRequest;
use App\Models\RentalStatus;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function show()
    {
        $rentalRequests = RentalRequest::all();
        $data = [
            'rentalRequests' => $rentalRequests
        ];

        return view('rental-request-show', $data);
    }

    public function approve(Request $request)
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

        return view('rental-request-complete', $data);
    }
}
