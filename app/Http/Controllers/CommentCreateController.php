<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentCreateController extends Controller
{
    public function create(Request $request)
    {
        $bookId = $request->validate([
            'book_id' => 'required|exists:books,id',
        ])['book_id'];

        $data = [
            'bookId' => $bookId
        ];
        return view('comment-create', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required | string | min:1 | max:1000',
            'user_id' => 'required | exists:users,id',
            'book_id' => 'required | exists:books,id',
            'rating' => 'required | integer | between:1,5',
        ]);

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->user_id = $validatedData['user_id'];
        $comment->book_id = $validatedData['book_id'];

        $comment->save();

        $data = [
            'comment' => $validatedData,
            'book_id' => $validatedData['book_id']
        ];

        return view('comment-store', $data);
    }
}
