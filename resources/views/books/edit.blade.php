@extends('layouts.admin')

@section('title', '書籍編集')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍編集</h1>
        <p class="text-secondary mb-0">
            書籍IDを入力して、登録情報を更新できます。
        </p>
    </div>

    @if (isset($book))

        <!-- 書籍編集フォーム -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">書籍情報の編集</h5>
                <small class="text-secondary">
                    書籍ID：{{ $book->id }}
                </small>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('admin.books.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{ $book->id }}">

                    <div class="row g-4">

                        <!-- 書籍名 -->
                        <div class="col-12">
                            <label for="title" class="form-label fw-semibold">
                                書籍名 <span class="badge bg-danger ms-1">必須</span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                value="{{ old('title', $book->title) }}"
                                required
                            >
                            @error('title')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                value="{{ old('author', $book->author) }}"
                            >
                            @error('author')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                value="{{ old('publisher', $book->publisher) }}"
                            >
                            @error('publisher')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                value="{{ old('isbn', $book->isbn) }}"
                            >
                            @error('isbn')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                value="{{ old('published_date', $book->published_date) }}"
                            >
                            @error('published_date')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- カテゴリ -->
                        <div class="col-12 col-md-6">
                            <label for="category_id" class="form-label fw-semibold">
                                カテゴリ
                            </label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">カテゴリを選択してください</option>
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected((string) old('category_id', $book->category_id) === (string) $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
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
                            >{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- 書籍画像 -->
                        <div class="col-12">
                            <label for="thumbnail" class="form-label fw-semibold">
                                書籍画像URL
                            </label>

                            @if ($book->thumbnail)
                                <div class="mb-3">
                                    <img
                                        src="{{ $book->thumbnail }}"
                                        alt="{{ $book->title }}"
                                        class="book-edit-thumbnail img-thumbnail"
                                    >
                                </div>
                            @endif

                            <input
                                type="url"
                                class="form-control"
                                id="thumbnail"
                                name="thumbnail"
                                placeholder="https://example.com/image.jpg"
                                value="{{ old('thumbnail', $book->thumbnail) }}"
                            >

                            <div class="form-text">
                                画像ファイルのURLを入力してください。例：http://127.0.0.1:8000/images/2_.jpg
                            </div>

                            @error('thumbnail')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <!-- ボタン -->
                    <div class="d-flex justify-content-between gap-2 mt-4 pt-3 border-top">

                        <button
                            type="submit"
                            class="btn btn-outline-danger"
                            formaction="/admin/books/erase"
                            formmethod="POST"
                            formnovalidate
                        >
                            書籍の削除確認へ
                        </button>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.books.edit') }}"
                               class="btn btn-outline-secondary">
                                キャンセル
                            </a>

                            <button type="submit" class="btn btn-primary">
                                変更を保存する
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    @else

        <!-- 書籍検索フォーム -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">編集する書籍のIDを入力</h5>
            </div>

            <div class="card-body p-4">

                <p class="text-secondary mb-4">
                    編集する書籍のIDを入力してください。
                </p>

                <form action="{{ route('admin.books.edit') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="id" class="form-label fw-semibold">書籍ID</label>
                        <input
                            type="number"
                            class="form-control"
                            id="id"
                            name="id"
                            min="1"
                            value="{{ old('id') }}"
                            required
                            autofocus
                        >

                        @error('id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="/admin/books/create"
                           class="btn btn-outline-secondary">
                            キャンセル
                        </a>

                        <button type="submit" class="btn btn-primary">
                            書籍を検索
                        </button>

                    </div>

                </form>

            </div>
        </div>

    @endif

@endsection