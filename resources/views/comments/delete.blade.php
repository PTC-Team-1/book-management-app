
@extends('layouts.general')

@section('title', 'コメント削除完了')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント削除完了</h1>
        <p class="text-secondary mb-0">
            以下のコメントを削除しました。
        </p>
    </div>

    <!-- 削除完了メッセージ -->
    <div class="alert alert-success" role="alert">
        コメントを正常に削除しました。
    </div>

    <!-- 削除したコメントの情報 -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">削除したコメント</h5>
        </div>

        <div class="card-body p-4">

            <!-- コメント情報 -->
            <div class="row g-4">

                <!-- コメントID -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        コメントID
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $comment['id'] }}"
                        disabled
                    >
                </div>

                <!-- 社員ID -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">
                        社員ID
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $comment['user_id'] ?? '未登録' }}"
                        disabled
                    >
                </div>

                <!-- 書籍ID -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">
                        書籍ID
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $comment['book_id'] }}"
                        disabled
                    >
                </div>

            </div>

            <!-- コメント内容 -->
            <div class="mt-4">
                <h6 class="fw-bold mb-3">コメント内容</h6>

                <div class="bg-light rounded p-3">
                    <p class="mb-0 text-break" style="white-space: pre-wrap;">{{ $comment['content'] }}</p>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('books.detail', ['book' => $comment->book_id]) }}"
                   class="btn btn-primary">
                    書籍詳細ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
