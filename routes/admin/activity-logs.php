<?php

use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
