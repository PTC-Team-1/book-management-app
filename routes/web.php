
<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    foreach (['home', 'notices', 'announcements', 'book-requests', 'books', 'comments', 'rentals'] as $routeFile) {
        require __DIR__ . "/{$routeFile}.php";
    }

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
        foreach (['notices', 'books', 'users', 'rentals', 'activity-logs', 'announcements', 'book-requests'] as $routeFile) {
            require __DIR__ . "/admin/{$routeFile}.php";
        }
    });
});
