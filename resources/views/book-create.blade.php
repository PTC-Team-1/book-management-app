
@extends('layouts.admin')

@section('title', '書籍登録')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍登録</h1>
        <p class="text-secondary mb-0">
            新しい書籍の情報を入力してください。
        </p>
    </div>

    <!-- 登録フォーム -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="/admin/books/store" method="POST">
                @csrf

                <div class="row g-4">

                    <!-- 書籍名 -->
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">
                            書籍名 <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="title"
                            name="title"
                            placeholder="書籍名を入力してください"
                            value="{{ old('title') }}"
                            required
                        >
                    </div>

                    <!-- 著者名 -->
                    <div class="col-12 col-md-6">
                        <label for="author" class="form-label fw-semibold">
                            著者名
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="author"
                            name="author"
                            placeholder="著者名を入力してください"
                            value="{{ old('author') }}"
                        >
                    </div>

                    <!-- 出版社 -->
                    <div class="col-12 col-md-6">
                        <label for="publisher" class="form-label fw-semibold">
                            出版社
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="publisher"
                            name="publisher"
                            placeholder="出版社を入力してください"
                            value="{{ old('publisher') }}"
                        >
                    </div>

                    <!-- ISBN -->
                    <div class="col-12 col-md-6">
                        <label for="isbn" class="form-label fw-semibold">
                            ISBN
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="isbn"
                            name="isbn"
                            placeholder="ISBNを入力してください"
                            value="{{ old('isbn') }}"
                        >
                    </div>

                    <!-- 出版日 -->
                    <div class="col-12 col-md-6">
                        <label for="published_date" class="form-label fw-semibold">
                            出版日
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="published_date"
                            name="published_date"
                            value="{{ old('published_date') }}"
                        >
                    </div>

                    <!-- 説明文 -->
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">
                            説明文
                        </label>
                        <textarea
                            class="form-control"
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="書籍の説明を入力してください"
                        >{{ old('description') }}</textarea>
                    </div>

                    <!-- 書籍画像 -->
                    <div class="col-12">
                        <label for="thumbnail" class="form-label fw-semibold">
                            書籍画像URL
                        </label>
                        <input
                            type="url"
                            class="form-control"
                            id="thumbnail"
                            name="thumbnail"
                            placeholder="https://example.com/image.jpg"
                            value="{{ old('thumbnail') }}"
                        >
                        <div class="form-text">
                            書籍画像のURLを入力してください。
                        </div>
                    </div>

                </div>

                <!-- ボタン -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <a href="/admin/users"
                       class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        書籍を登録する
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection
