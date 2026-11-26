<?php

use App\Http\Controllers\AdminBookRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/book-requests', [AdminBookRequestController::class, 'index'])->name('book-requests.index');
Route::patch('/book-requests/{bookRequest}', [AdminBookRequestController::class, 'update'])->name('book-requests.update');
