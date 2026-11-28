@extends('layouts.general')

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

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">登録したコメント</h5>
        </div>

        <div class="card-body p-4">

            <!-- コメント本文 -->
            <div class="mb-4">
                <div class="text-secondary small mb-2">
                    コメント本文
                </div>
                <div class="border rounded p-3"
                     style="white-space: pre-wrap;">{{ $comment['content'] }}</div>
            </div>

            <!-- 対象書籍情報 -->
            <h5 class="fw-bold mb-3">対象書籍</h5>

            <div class="border rounded p-3">
                <div class="mb-3">
                    <div class="text-secondary small mb-1">書籍名</div>
                    <div class="fw-semibold">{{ $book->title }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-secondary small mb-1">著者</div>
                    <div class="fw-semibold">{{ $book->author }}</div>
                </div>

                <div>
                    <div class="text-secondary small mb-1">ISBN</div>
                    <div class="fw-semibold">{{ $book->isbn }}</div>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('books.detail', ['book' => $book->id]) }}"
                   class="btn btn-primary">
                    書籍詳細ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection