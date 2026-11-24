<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentCreateController extends Controller
{
    public function create(Book $book)
    {
        $data = [
            'book_id' => $book->id
        ];

        return view('comments.create', $data);
    }

    public function store(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'content' => 'required | string | min:1 | max:1000',
            'rating' => 'required | integer | between:1,5',
        ]);

        $user = Auth::user();

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->user_id = $user->id;
        $comment->book_id = $book->id;

        $comment->save();

        $data = [
            'comment' => $validatedData,
            'book' => $book,
        ];

        return view('comments.store', $data);
    }
}
