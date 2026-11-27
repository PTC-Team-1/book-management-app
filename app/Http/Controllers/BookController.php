<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show(Book $book)
    {
        $canRequstBook = $book->canRequestBook();

        $data = [
            'book' => $book,
            'comments' => $book->comments()->with('user')->latest()->get(),
            'canRequstBook' => $canRequstBook
        ];

        return view('books.detail', $data);
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'q' => ['required', 'string']
        ]);

        $books = Book::search($validatedData['q'])->latest()->get();

        $data = [
            'books' => $books,
            'keyword' => $validatedData['q']
        ];

        return view('books.search', $data);
    }
}
