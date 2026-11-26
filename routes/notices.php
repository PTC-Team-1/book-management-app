<?php

use App\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;

Route::get('/books/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/books/notices/{notice}', [NoticeController::class, 'show'])->name('notices.detail');
