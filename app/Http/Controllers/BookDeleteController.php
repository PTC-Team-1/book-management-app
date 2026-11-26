<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class BookDeleteController extends Controller
{
    public function erase(Request $request)
    {

        if ($request->isMethod('get')) {
            return view('books.erase');
        }

        $bookId = $request->input('id');
        $bookData = Book::find($bookId);
        $data = [
            'book' => $bookData
        ];
        return view('books.erase', $data);
    }

    public function delete(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => 'required | exists:books,id',
        ]);

        $book = Book::find($validatedData['id']);
        $book->delete();
        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_DELETED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        $data = [
            'book' => $book
        ];

        return view('books.delete', $data);
    }
}
