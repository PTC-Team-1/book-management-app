
@extends('layouts.admin')

@section('title', 'コメント作成')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">コメント作成</h1>
        <p class="text-secondary mb-0">
            書籍に対するコメントを入力してください。
        </p>
    </div>

    <!-- 登録フォーム -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('books.comments.store', ['book' => $book_id]) }}" method="POST">
                @csrf
                <div class="row g-4">

                    <!-- 星評価 -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            星評価 <span class="text-danger">*</span>
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
                                        {{ old('rating', 5) == $i ? 'checked' : '' }}
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
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- コメント本文 -->
                    <div class="col-12">
                        <label for="content" class="form-label fw-semibold">
                            コメント本文 <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('content') is-invalid @enderror"
                            id="content"
                            name="content"
                            rows="6"
                            placeholder="コメントを入力してください"
                            required
                        >{{ old('content') }}</textarea>

                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- ボタン -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <a href="/books/{{ $book_id }}"
                       class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        コメントを登録する
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection
