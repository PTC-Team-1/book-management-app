<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentDeleteController extends Controller
{
    public function erase(Request $request) {
        
        $commentId = $request->query('comment_id');
        $bookId = $request->query('book_id');
        $userId = $request->query('user_id');
        $commentData = Comment::find($commentId);
        $data = [
            'comment' => $commentData,
            'book_id' => $bookId,
            'user_id' => $userId
        ];
        return view('comment-erase', $data);
    }

    public function delete(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required | exists:comments,id',
        ]);

        $comment = Comment::find($validatedData['id']);
        $comment->delete();
        $data = [
            'comment' => $comment
        ];

        return view('comment-delete', $data);
    }
}
