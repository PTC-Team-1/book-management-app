<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Comment;
use App\Services\ActivityLogger;
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

    public function store(Request $request, Book $book, ActivityLogger $activityLogger)
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

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_CREATED,
            ActivityLog::SUBJECT_COMMENT,
            $comment->id,
        );

        $data = [
            'comment' => $validatedData,
            'book' => $book,
        ];

        return view('comments.store', $data);
    }
}
