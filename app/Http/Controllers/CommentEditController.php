<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentEditController extends Controller
{
    public function edit(Request $request)
    {
        $comment = Comment::find($request->query('comment_id'));
        $data = [
            'comment' => $comment,
            'user_id' => $request->query('user_id'),
            'book_id' => $request->query('book_id'),
        ];

        return view('comment-edit', $data);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => ['required', 'exists:comments,id'],
            'content' => ['required', 'string', 'min:1', 'max:1000'],
            // 認証機能を付けたらコメントを外す
            // 'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ]);

        $comment = Comment::find($validatedData['id']);
        $comment->content = $validatedData['content'];
        $comment->rating = $validatedData['rating'];

        $comment->save();

        $data = [
            'comment' => $validatedData,
        ];

        return view('comment-update', $data);
    }
}
