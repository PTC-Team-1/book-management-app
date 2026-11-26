<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
