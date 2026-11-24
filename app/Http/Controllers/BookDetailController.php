<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RentalRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookDetailController extends Controller
{
    public function show(Book $book)
    {
        /** @var User $user */
        $user = Auth::user();

        $hasRentalRequst = $user->bookRentalRequests()
            ->where('book_id', $book->id)
            ->first();

        $data = [
            'book' => $book,
            'comments' => $book->comments()->with('user')->get(),
            'hasRentalRequst' => $hasRentalRequst
        ];

        return view('book-detail', $data);
    }
}
