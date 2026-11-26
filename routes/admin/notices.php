<?php

use App\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;

Route::get('/books/notices/{notice}/edit', [NoticeController::class, 'edit'])->name('notices.edit');
Route::post('/books/notices/{notice}', [NoticeController::class, 'update'])->name('notices.update');
Route::post('/books/notices/{notice}/erase', [NoticeController::class, 'erase'])->name('notices.delete');
