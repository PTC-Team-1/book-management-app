
@extends('layouts.general')

@section('title', 'コメント編集')

@section('content')

    {{-- 2026年11月27日追記: 必須項目の表示を全フォームで共通の赤いアスタリスクに揃える。 --}}
    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント編集</h1>
        <p class="text-secondary mb-0">
            コメント内容を確認し、更新できます。
        </p>
    </div>

    <!-- コメント編集フォーム -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">
            <h5 class="fw-bold mb-0">コメント情報の編集</h5>
            <small class="text-secondary">
                コメントID：{{ $comment->id }}
            </small>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('books.comments.update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" value="{{ $comment->id }}">
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                <input type="hidden" name="book_id" value="{{ $book_id }}">

                <div class="row g-4">

                    <!-- 社員ID -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            社員ID
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

                    <!-- 星評価 -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            星評価 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                        </label>

                        <div class="d-flex gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <div>
                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="rating"
                                        id="rating{{ $i }}"
                                        value="{{ $i }}"
                                        autocomplete="off"
                                        {{ old('rating', $comment->rating) == $i ? 'checked' : '' }}
                                    >

                                    <label
                                        class="btn btn-outline-warning"
                                        for="rating{{ $i }}"
                                    >
                                        {{ $i }} ★
                                    </label>
                                </div>
                            @endfor
                        </div>

                        @error('rating')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- コメント内容 -->
                    <div class="col-12">
                        <label for="content" class="form-label fw-semibold">
                            コメント内容 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                        </label>

                        <textarea
                            class="form-control @error('content') is-invalid @enderror"
                            id="content"
                            name="content"
                            rows="6"
                            placeholder="コメント内容を入力してください"
                            required
                        >{{ old('content', $comment->content) }}</textarea>

                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- ボタン -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('books.detail', ['book' => $book_id]) }}"
                       class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        変更を保存する
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection
