<?php

use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::get('/books/rentals/request', [RentalController::class, 'show'])->name('books.rentals.index');
Route::post('/books/rentals/approve', [RentalController::class, 'approve'])->name('books.rentals.approve');
