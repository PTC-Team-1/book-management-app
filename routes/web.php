
<?php

use App\Http\Controllers\BookCreateController;
use App\Http\Controllers\BookDeleteController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\BookEditController;
use App\Http\Controllers\BookSearchController;
use App\Http\Controllers\CommentCreateController;
use App\Http\Controllers\CommentDeleteController;
use App\Http\Controllers\CommentEditController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\UserDeleteController;
use App\Http\Controllers\UserEditController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserSearchController;
use Illuminate\Support\Facades\Route;


// 一般社員・総務部社員共通
Route::middleware(['auth'])->group(function () {

    // ホーム
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    // 書籍検索
    Route::get('/books/search', [BookSearchController::class, 'search'])
        ->name('books.search');

    // 書籍詳細
    Route::get('/books/{book}', [BookDetailController::class, 'show'])
        ->name('books.detail');

    // コメント作成
    Route::get('/books/{book}/comments/create', [CommentCreateController::class, 'create'])
        ->name('books.comments.create');
    Route::post('/books/{book}/comments/store', [CommentCreateController::class, 'store'])
        ->name('books.comments.store');

    // コメント編集
    Route::get('/books/comments/edit', [CommentEditController::class, 'edit'])
        ->name('books.comments.edit');
    Route::post('/books/comments/update', [CommentEditController::class, 'update'])
        ->name('books.comments.update');

    // コメント削除
    Route::get('/books/comments/erase', [CommentDeleteController::class, 'erase'])
        ->name('books.comments.delete.confirm');
    Route::post('/books/comments/delete', [CommentDeleteController::class, 'delete'])
        ->name('books.comments.destroy');

    // 貸出予約
    Route::post('/books/rental/request', [RentalController::class, 'request'])
        ->name('books.rentals.request');


    Route::middleware(['admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // 書籍関係

            // 書籍追加
            Route::get('/books/create', [BookCreateController::class, 'create'])
                ->name('books.create');
            Route::post('/books/store', [BookCreateController::class, 'store'])
                ->name('books.store');

            // 書籍編集
            Route::get('/books/edit', [BookEditController::class, 'edit'])
                ->name('books.edit');
            Route::post('/books/edit', [BookEditController::class, 'edit'])
                ->name('books.edit.search');
            Route::post('/books/update', [BookEditController::class, 'update'])
                ->name('books.update');

            // 書籍削除
            Route::get('/books/erase', [BookDeleteController::class, 'erase'])
                ->name('books.delete.confirm');
            Route::post('/books/erase', [BookDeleteController::class, 'erase'])
                ->name('books.delete.search');
            Route::post('/books/delete', [BookDeleteController::class, 'delete'])
                ->name('books.destroy');


            // 社員関係

            // 社員一覧
            Route::get('/users', [UserListController::class, 'index'])
                ->name('users.index');

            // 社員登録
            Route::get('/users/create', [UserCreateController::class, 'create'])
                ->name('users.create');
            Route::post('/users/store', [UserCreateController::class, 'store'])
                ->name('users.store');

            // 社員編集
            Route::get('/users/edit', [UserEditController::class, 'edit'])
                ->name('users.edit');
            Route::post('/users/edit', [UserEditController::class, 'edit'])
                ->name('users.edit.search');
            Route::post('/users/update', [UserEditController::class, 'update'])
                ->name('users.update');

            // 社員削除
            Route::get('/users/erase', [UserDeleteController::class, 'erase'])
                ->name('users.delete.confirm');
            Route::post('/users/erase', [UserDeleteController::class, 'erase'])
                ->name('users.delete.search');
            Route::post('/users/delete', [UserDeleteController::class, 'delete'])
                ->name('users.destroy');

            // 社員検索
            Route::get('/users/search', [UserSearchController::class, 'search'])
                ->name('users.search');
            Route::post('/users/search', [UserSearchController::class, 'search'])
                ->name('users.search.submit');

            // 貸出申請一覧
            Route::get('/books/rentals/request', [RentalController::class, 'show'])
                ->name('books.rentals.index');

            // 貸出承認
            Route::post('/books/rentals/approve', [RentalController::class, 'approve'])
                ->name('books.rentals.approve');
        });
});
