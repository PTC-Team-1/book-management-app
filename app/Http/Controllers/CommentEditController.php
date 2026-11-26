<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Comment;
use App\Services\ActivityLogger;
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

        return view('comments.edit', $data);
    }

    public function update(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => ['required', 'exists:comments,id'],
            'content' => ['required', 'string', 'min:1', 'max:1000'],
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ]);

        $comment = Comment::find($validatedData['id']);
        $comment->content = $validatedData['content'];
        $comment->rating = $validatedData['rating'];

        $comment->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_UPDATED,
            ActivityLog::SUBJECT_COMMENT,
            $comment->id,
        );

        $data = [
            'comment' => $validatedData,
        ];

        return view('comments.update', $data);
    }
}
