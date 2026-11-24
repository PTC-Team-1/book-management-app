
@extends('layouts.admin')

@section('title', 'コメント削除')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント削除</h1>
        <p class="text-secondary mb-0">
            削除するコメントの内容を確認してから削除できます。
        </p>
    </div>

    <!-- 削除確認カード -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">削除対象のコメント</h5>
        </div>

        <div class="card-body p-4">

            <!-- 警告メッセージ -->
            <div class="alert alert-danger" role="alert">
                <strong>注意：</strong>
                以下のコメントを削除します。この操作は取り消せません。
            </div>

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
                        value="{{ $comment->id }}"
                        disabled
                    >
                </div>

                <!-- ユーザーID -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">
                        ユーザーID
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $user_id ?? '未登録' }}"
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
                        value="{{ $book_id }}"
                        disabled
                    >
                </div>

            </div>

            <!-- コメント内容 -->
            <div class="mt-4">
                <h6 class="fw-bold mb-3">コメント内容</h6>

                <div class="bg-light rounded p-3">
                    <p class="mb-0 text-break" style="white-space: pre-wrap;">{{ $comment->content }}</p>
                </div>
            </div>

            <!-- 削除ボタン -->
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                <a href="{{ route('books.detail', ['book' => $comment->book_id]) }}"
                   class="btn btn-outline-secondary">
                    キャンセル
                </a>

                <form action="{{ route('books.comments.destroy') }}" method="POST">
                    @csrf

                    <input
                        type="hidden"
                        name="id"
                        value="{{ $comment->id }}"
                    >

                    <button type="submit" class="btn btn-danger">
                        コメントを削除する
                    </button>
                </form>

            </div>

        </div>
    </div>

@endsection
