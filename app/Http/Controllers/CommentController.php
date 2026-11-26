<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Comment;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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

    public function erase(Request $request)
    {

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

    public function delete(Request $request, ActivityLogger $activityLogger)
    {
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
