<?php

use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\BookRequestLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/book-requests', [BookRequestController::class, 'index'])->name('book-requests.index');
Route::post('/book-requests', [BookRequestController::class, 'store'])->name('book-requests.store');
Route::post('/book-requests/{bookRequest}/likes', [BookRequestLikeController::class, 'toggle'])->name('book-requests.likes.toggle');
