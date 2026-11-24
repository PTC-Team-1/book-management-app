<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookSearchController extends Controller
{
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
