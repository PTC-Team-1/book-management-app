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
        $title = $request->query('title');
        // TODO: 書籍名以外でも検索できるようにする
        $books = Book::where('title', 'LIKE', "%{$title}%")->get();

        $data = [
            'books' => $books,
            'keyword' => $title
        ];

        return view('books.search', $data);
    }
}
