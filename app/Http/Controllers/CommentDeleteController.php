<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Comment;
use App\Services\ActivityLogger;
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
        return view('comments.erase', $data);
    }

    public function delete(Request $request, ActivityLogger $activityLogger) {
        $validatedData = $request->validate([
            'id' => 'required | exists:comments,id',
        ]);

        $comment = Comment::find($validatedData['id']);
        $comment->delete();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_DELETED,
            ActivityLog::SUBJECT_COMMENT,
            $comment->id,
        );
        $data = [
            'comment' => $comment
        ];

        return view('comments.delete', $data);
    }
}
