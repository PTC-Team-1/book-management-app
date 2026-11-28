
@extends('layouts.general')

@section('title', 'コメント編集結果')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント編集完了</h1>
        <p class="text-secondary mb-0">
            以下のコメントの編集が完了しました。
        </p>
    </div>

    <!-- 編集完了メッセージ -->
    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <div>
            コメントを正常に更新しました。
        </div>
    </div>

    <!-- コメント情報カード -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">編集したコメント</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- コメント本文 -->
                <div class="col-12">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            コメント本文
                        </div>

                        <div class="fw-semibold text-break"
                             style="white-space: pre-wrap;">{{ $comment['content'] }}</div>
                    </div>
                </div>

                <!-- 星評価 -->
                <div class="col-12">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            星評価
                        </div>

                        <div>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment['rating'])
                                    <span class="text-warning fs-5">★</span>
                                @else
                                    <span class="text-secondary fs-5">☆</span>
                                @endif
                            @endfor

                            <span class="text-secondary small ms-1">
                                {{ $comment['rating'] }} / 5
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 社員ID -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            社員ID
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
                            {{ $comment['book_id'] }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('books.detail', ['book' => $comment['book_id']])}}"
                   class="btn btn-primary">
                    書籍詳細ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
