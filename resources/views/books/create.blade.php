@extends('layouts.admin')

@section('title', '書籍登録')

@section('content')
    @php
        $showSingleTab = session('active_tab') === 'single'
            || (old('title') !== null && old('books') === null);
    @endphp

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍登録</h1>
        <p class="text-secondary mb-0">
            個別登録、またはISBNを最大10冊まで連続で読み取り、内容を確認してから一括登録できます。登録方法は下のタブで切り替えられます。
        </p>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="status">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">入力内容を確認してください。</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <ul class="book-registration-tabs nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link {{ $showSingleTab ? '' : 'active' }}"
                id="batch-mode-tab"
                data-bs-toggle="tab"
                data-bs-target="#batch-mode-pane"
                type="button"
                role="tab"
                aria-controls="batch-mode-pane"
                aria-selected="{{ $showSingleTab ? 'false' : 'true' }}"
                title="登録方法を切り替え"
            >
                ISBN連続登録
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link {{ $showSingleTab ? 'active' : '' }}"
                id="single-mode-tab"
                data-bs-toggle="tab"
                data-bs-target="#single-mode-pane"
                type="button"
                role="tab"
                aria-controls="single-mode-pane"
                aria-selected="{{ $showSingleTab ? 'true' : 'false' }}"
                title="登録方法を切り替え"
            >
                個別登録
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div
            class="tab-pane fade {{ $showSingleTab ? '' : 'show active' }}"
            id="batch-mode-pane"
            role="tabpanel"
            aria-labelledby="batch-mode-tab"
        >
            @include('partials.book-batch-form')
        </div>
        <div
            class="tab-pane fade {{ $showSingleTab ? 'show active' : '' }}"
            id="single-mode-pane"
            role="tabpanel"
            aria-labelledby="single-mode-tab"
        >

    <!-- 登録フォーム -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <!-- 書籍名 -->
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">
                            書籍名 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="title"
                            name="title"
                            placeholder="書籍名を入力してください"
                            value="{{ old('title') }}"
                            required
                            autofocus
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

                    <!-- カテゴリ -->
                    <div class="col-12 col-md-6">
                        <label for="category_id" class="form-label fw-semibold">
                            カテゴリ
                        </label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">カテゴリを選択してください</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected((string) old('category_id') === (string) $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 書籍画像 -->
                    <div class="col-12">
                        <label for="cover_image" class="form-label fw-semibold">
                            書籍画像
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="cover_image"
                            name="cover_image"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        <div class="form-text">
                            JPEG、PNG、WebP形式の画像をアップロードできます。
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.books.create') }}" class="btn btn-outline-secondary">
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