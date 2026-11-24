
@extends('layouts.admin')

@section('title', 'コメント登録完了')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント登録完了</h1>
        <p class="text-secondary mb-0">
            コメントの登録が完了しました。
        </p>
    </div>

    <!-- 登録完了メッセージ -->
    <div class="alert alert-success" role="alert">
        コメントを正常に登録しました。
    </div>

    <!-- 登録したコメントの情報 -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">登録したコメント</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- コメント本文 -->
                <div class="col-12">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            コメント本文
                        </div>
                        <div class="fw-semibold"
                             style="white-space: pre-wrap;">{{ $comment['content'] }}</div>
                    </div>
                </div>

                <!-- 投稿ユーザーID -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            投稿ユーザーID
                        </div>
                        <div class="fw-semibold">
                            {{ $comment['user_id'] ?? '未登録' }}
                        </div>
                    </div>
                </div>

                <!-- 書籍ID -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            書籍ID
                        </div>
                        <div class="fw-semibold">
                            {{ $book_id }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="/books/{{ $book_id }}"
                   class="btn btn-primary">
                    書籍詳細ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
