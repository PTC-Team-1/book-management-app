<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class BookEditController extends Controller
{
    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('books.edit');
        }

        $bookId = $request->input('id');
        $bookData = Book::find($bookId);
        $data = [
            'book' => $bookData
        ];
        return view('books.edit', $data);
    }

    public function update(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => 'required | exists:books,id',
            'title' => 'required | string | min:1 | max:100',
            'author' => 'nullable | string',
            'publisher' => 'nullable | string',
            'published_date' => 'nullable | date',
            'isbn' => 'nullable | string',
            'description' => 'nullable | string',
            'thumbnail' => 'nullable | string',
        ]);

        $book = Book::find($validatedData['id']);
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->publisher = $validatedData['publisher'];
        $book->isbn = $validatedData['isbn'];
        $book->published_date = $validatedData['published_date'];
        $book->description = $validatedData['description'];
        $book->thumbnail = $validatedData['thumbnail'];

        $book->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_UPDATED,
            ActivityLog::SUBJECT_BOOK,
            $book->id,
        );

        $data = [
            'book' => $validatedData,
        ];

        return view('books.update', $data);
    }
}
