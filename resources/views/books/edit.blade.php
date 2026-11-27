@extends('layouts.admin')

@section('title', '書籍編集')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍編集</h1>
        <p class="text-secondary mb-0">
        書籍名で検索して、登録情報を更新できます。
        </p>
    </div>

    @if (isset($book))

        <!-- 書籍編集フォーム -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">書籍情報の編集</h5>
                <small class="text-secondary">
                    書籍ID:{{ $book->id }}
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
                                書籍名 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
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
                                画像ファイルのURLを入力してください。例:http://127.0.0.1:8000/images/2_.jpg
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

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <h5 class="fw-bold mb-0">編集する書籍を選択</h5>
                    <span class="badge bg-secondary" id="book-search-count">最新10件</span>
                </div>
            </div>

            <div class="card-body p-4">
                <label for="book-title-search" class="form-label fw-semibold">書籍名</label>
                <input
                    type="search"
                    class="form-control"
                    id="book-title-search"
                    placeholder="書籍名を入力してください"
                    maxlength="255"
                    autocomplete="off"
                    autofocus
                    {{-- data-search-url="{{ route('admin.books.edit.lookup') }}" --}}
                >
                <div class="form-text mb-3">
                    最近登録された書籍を10件表示します。入力すると書籍名で絞り込めます。
                </div>
                <div id="book-search-status" class="small text-secondary mb-3" role="status" aria-live="polite">
                    最近登録された書籍を表示しています。
                </div>
                <div
                    class="list-group"
                    id="book-search-results"
                    data-delete-url="{{ route('admin.books.delete.search') }}"
                    data-csrf-token="{{ csrf_token() }}"
                >
                    @forelse ($books as $candidate)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <a
                                    href="{{ route('admin.books.edit', ['id' => $candidate->id]) }}"
                                    class="text-decoration-none text-reset flex-grow-1"
                                >
                                    <span class="d-block fw-semibold">{{ $candidate->title }}</span>
                                    <small class="text-secondary">
                                        {{ $candidate->author ?: '著者未登録' }}
                                        @if ($candidate->isbn)
                                            ・ISBN {{ $candidate->isbn }}
                                        @endif
                                    </small>
                                </a>
                                <div class="d-flex flex-shrink-0 gap-2">
                                    <a
                                        href="{{ route('admin.books.edit', ['id' => $candidate->id]) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        編集
                                    </a>
                                    <form action="{{ route('admin.books.delete.search') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $candidate->id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-secondary py-4">
                            登録されている書籍はありません。
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            (() => {
                const searchInput = document.getElementById('book-title-search');
                const results = document.getElementById('book-search-results');
                const count = document.getElementById('book-search-count');
                const status = document.getElementById('book-search-status');
                let debounceTimer;
                let activeRequest;

                const renderResults = (books) => {
                    results.replaceChildren();
                    count.textContent = `${books.length} / 10件`;

                    if (books.length === 0) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'list-group-item text-center text-secondary py-4';
                        emptyState.textContent = '該当する書籍が見つかりませんでした。';
                        results.appendChild(emptyState);
                        return;
                    }

                    books.forEach((book) => {
                        const item = document.createElement('div');
                        const row = document.createElement('div');
                        const detailsLink = document.createElement('a');
                        const details = document.createElement('span');
                        const title = document.createElement('span');
                        const metadata = document.createElement('small');
                        const actions = document.createElement('div');
                        const editLink = document.createElement('a');
                        const deleteForm = document.createElement('form');
                        const csrfInput = document.createElement('input');
                        const bookIdInput = document.createElement('input');
                        const deleteButton = document.createElement('button');

                        item.className = 'list-group-item';
                        row.className = 'd-flex justify-content-between align-items-center gap-3';
                        detailsLink.href = book.url;
                        detailsLink.className = 'text-decoration-none text-reset flex-grow-1';
                        title.className = 'd-block fw-semibold';
                        title.textContent = book.title;
                        metadata.className = 'text-secondary';
                        metadata.textContent = [
                            book.author || '著者未登録',
                            book.isbn ? `ISBN ${book.isbn}` : '',
                        ].filter(Boolean).join(' ・ ');
                        actions.className = 'd-flex flex-shrink-0 gap-2';
                        editLink.href = book.url;
                        editLink.className = 'btn btn-primary btn-sm';
                        editLink.textContent = '編集';
                        deleteForm.action = results.dataset.deleteUrl;
                        deleteForm.method = 'POST';
                        deleteForm.className = 'm-0';
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = results.dataset.csrfToken;
                        bookIdInput.type = 'hidden';
                        bookIdInput.name = 'id';
                        bookIdInput.value = book.id;
                        deleteButton.type = 'submit';
                        deleteButton.className = 'btn btn-outline-danger btn-sm';
                        deleteButton.textContent = '削除';

                        details.append(title, metadata);
                        detailsLink.appendChild(details);
                        deleteForm.append(csrfInput, bookIdInput, deleteButton);
                        actions.append(editLink, deleteForm);
                        row.append(detailsLink, actions);
                        item.appendChild(row);
                        results.appendChild(item);
                    });
                };

                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    activeRequest?.abort();

                    const title = searchInput.value.trim();
                    const controller = new AbortController();
                    activeRequest = controller;
                    status.textContent = '検索しています…';

                    debounceTimer = setTimeout(async () => {
                        try {
                            const response = await fetch(
                                `${searchInput.dataset.searchUrl}?title=${encodeURIComponent(title)}`,
                                {
                                    headers: { Accept: 'application/json' },
                                    signal: controller.signal,
                                }
                            );

                            if (!response.ok) {
                                throw new Error('書籍候補を取得できませんでした。');
                            }

                            const books = await response.json();
                            renderResults(books);
                            status.textContent = title
                                ? '書籍名で検索した結果を表示しています。'
                                : '最近登録された書籍を表示しています。';
                        } catch (error) {
                            if (error instanceof Error && error.name === 'AbortError') {
                                return;
                            }

                            status.textContent = error instanceof Error
                                ? error.message
                                : '書籍候補を取得できませんでした。';
                        }
                    }, 250);
                });
            })();
        </script>

    @endif

@endsection