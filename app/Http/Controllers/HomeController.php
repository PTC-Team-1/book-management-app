<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function  index()
    {
        $books = Book::all();

        $hasUnreadNotices = Notice::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->exists();

        $data = [
            'books' => $books,
            'hasUnreadNotices' => $hasUnreadNotices
        ];
        return view('index', $data);
    }
}
