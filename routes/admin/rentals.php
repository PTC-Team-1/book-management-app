<?php

use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// 書籍貸出申請ページ
Route::get('/books/rentals/request', [RentalController::class, 'create'])
    ->name('books.rentals.request.create');

// 書籍貸出承認アクション
Route::post('/books/rentals/approve', [RentalController::class, 'approve'])
    ->name('books.rentals.approve');

// 書籍返却入力フォームページ
Route::get('/books/rentals/return', [RentalController::class, 'returnForm'])
    ->name('books.rentals.return.create');

// 書籍返却アクション
Route::post('/books/rentals/return', [RentalController::class, 'return'])
    ->name('books.rentals.return.store');

// 一括書籍返却アクション
Route::post('/books/rentals/return/batch-store', [RentalController::class, 'returnBatch'])
    ->name('books.rentals.return.batch-store');
