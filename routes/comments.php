<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/books/{book}/comments/create', [CommentController::class, 'create'])->name('books.comments.create');
Route::post('/books/{book}/comments/store', [CommentController::class, 'store'])->name('books.comments.store');
Route::get('/books/comments/edit', [CommentController::class, 'edit'])->name('books.comments.edit');
Route::post('/books/comments/update', [CommentController::class, 'update'])->name('books.comments.update');
Route::get('/books/comments/erase', [CommentController::class, 'erase'])->name('books.comments.delete.confirm');
Route::post('/books/comments/delete', [CommentController::class, 'delete'])->name('books.comments.destroy');
