<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/edit', [UserController::class, 'edit'])->name('users.edit.search');
Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
Route::get('/users/erase', [UserController::class, 'erase'])->name('users.delete.confirm');
Route::post('/users/erase', [UserController::class, 'erase'])->name('users.delete.search');
Route::post('/users/delete', [UserController::class, 'delete'])->name('users.destroy');
