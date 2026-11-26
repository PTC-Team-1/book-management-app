<?php

use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books/batch-store', [BookController::class, 'storeBatch'])->name('books.batch-store');
Route::get('/books/isbn-lookup', [BookController::class, 'lookupIsbn'])->name('books.isbn-lookup');
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
Route::get('/books/edit', [BookController::class, 'edit'])->name('books.edit');
Route::post('/books/edit', [BookController::class, 'edit'])->name('books.edit.search');
Route::post('/books/update', [BookController::class, 'update'])->name('books.update');
Route::get('/books/erase', [BookController::class, 'erase'])->name('books.delete.confirm');
Route::post('/books/erase', [BookController::class, 'erase'])->name('books.delete.search');
Route::post('/books/delete', [BookController::class, 'delete'])->name('books.destroy');
