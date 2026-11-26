<?php

use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::post('/books/rental/request', [RentalController::class, 'request'])->name('books.rentals.request');
