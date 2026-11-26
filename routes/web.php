
<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\admin\BookController as AdminBookController;
use App\Http\Controllers\AdminBookRequestController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCreateController;
use App\Http\Controllers\BookDeleteController;
use App\Http\Controllers\BookEditController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\BookRequestLikeController;
use App\Http\Controllers\CommentCreateController;
use App\Http\Controllers\CommentDeleteController;
use App\Http\Controllers\CommentEditController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
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

    // お知らせ表示・閲覧
    Route::get('/books/notices', [NoticeController::class, 'index'])
        ->name('notices.index');
    Route::get('books/notices/{notice}', [NoticeController::class, 'show'])
        ->name('notices.detail');

    // 全体のお知らせ詳細
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])
        ->name('announcements.show');

    Route::get('/book-requests', [BookRequestController::class, 'index'])
        ->name('book-requests.index');
    Route::post('/book-requests', [BookRequestController::class, 'store'])
        ->name('book-requests.store');
    Route::post('/book-requests/{bookRequest}/likes', [BookRequestLikeController::class, 'toggle'])
        ->name('book-requests.likes.toggle');

    // 書籍検索
    Route::get('/books/search', [BookController::class, 'search'])
        ->name('books.search');

    // 書籍詳細
    Route::get('/books/{book}', [BookController::class, 'show'])
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
            // お知らせ関係
            Route::get('/books/notices/{notice}/edit', [NoticeController::class, 'edit'])
                ->name('notices.edit');
            Route::post('/books/notices/{notice}', [NoticeController::class, 'update'])
                ->name('notices.update');
            Route::post('/books/notices/{notice}/erase', [NoticeController::class, 'erase'])
                ->name('notices.delete');

            // 書籍関係

            // 書籍追加
            Route::get('/books/create', [AdminBookController::class, 'create'])
                ->name('books.create');
            // ISBN用の書籍追加
            Route::post('/books/batch-store', [AdminBookController::class, 'storeBatch'])
                ->name('books.batch-store');
            //ISBNを使用してAPIからデータの取得
            Route::get('/books/isbn-lookup', [AdminBookController::class, 'lookupIsbn'])
                ->name('books.isbn-lookup');

            Route::post('/books/store', [AdminBookController::class, 'store'])
                ->name('books.store');

            // 書籍編集
            Route::get('/books/edit', [AdminBookController::class, 'edit'])
                ->name('books.edit');
            Route::post('/books/edit', [AdminBookController::class, 'edit'])
                ->name('books.edit.search');
            Route::post('/books/update', [AdminBookController::class, 'update'])
                ->name('books.update');

            // 書籍削除
            Route::get('/books/erase', [AdminBookController::class, 'erase'])
                ->name('books.delete.confirm');
            Route::post('/books/erase', [AdminBookController::class, 'erase'])
                ->name('books.delete.search');
            Route::post('/books/delete', [AdminBookController::class, 'delete'])
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

            // 書籍返却
            // Route::post('/books/rentals/return', [RentalController::class, 'return'])
            //     ->name('books.rentals.return');

            // 管理者の操作ログ一覧
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])
                ->name('activity-logs.index');

            // 全体のお知らせ
            Route::get('/announcements', [AnnouncementController::class, 'index'])
                ->name('announcements.index'); // 2026年11月26日追加: 管理者のお知らせ一覧
            Route::post('/announcements', [AnnouncementController::class, 'store'])
                ->name('announcements.store'); // 2026年11月26日追加: 管理者がお知らせを新規登録
            Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
                ->name('announcements.destroy'); // 2026年11月26日追加: 管理者がお知らせを削除

            // 書籍リクエスト
            Route::get('/book-requests', [AdminBookRequestController::class, 'index'])
                ->name('book-requests.index'); // 2026年11月25日追加: 管理者がリクエスト一覧を表示
            Route::patch('/book-requests/{bookRequest}', [AdminBookRequestController::class, 'update'])
                ->name('book-requests.update'); // 2026年11月25日追加: 管理者が状況とコメントを更新
        });
});
