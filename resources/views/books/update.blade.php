
@extends('layouts.admin')

@section('title', '書籍編集結果')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍編集完了</h1>
        <p class="text-secondary mb-0">
            以下の書籍の編集が完了しました。
        </p>
    </div>

    <!-- 編集完了メッセージ -->
    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <div>
            書籍情報を正常に更新しました。
        </div>
    </div>

    <!-- 書籍情報カード -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">編集した書籍</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- 書籍画像 -->
                <div class="col-12 col-md-4">
                    <div class="bg-body-secondary rounded overflow-hidden d-flex justify-content-center align-items-center"
                        style="aspect-ratio: 3 / 4; width: 100%;">
                        @if (!empty($book->cover_image_path))
                            <img
                                src="{{ asset('storage/' . $book->cover_image_path) }}"
                                alt="{{ $book->title }}"
                                class="w-100 h-100"
                                style="object-fit: contain;"
                            >
                        @else
                            <div class="book-thumbnail-placeholder d-flex justify-content-center align-items-center bg-light text-secondary w-100 h-100">
                                サムネイルなし
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 書籍情報 -->
                <div class="col-12 col-md-8">

                    <h4 class="fw-bold mb-4">
                        {{ $book['title'] }}
                    </h4>

                    <table class="table table-bordered align-middle mb-0">
                        <tbody>
                            <tr>
                                <th class="table-light">著者</th>
                                <td>{{ $book['author'] ?? '未登録' }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">出版社</th>
                                <td>{{ $book['publisher'] ?? '未登録' }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">ISBN</th>
                                <td>{{ $book['isbn'] ?? '未登録' }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">出版日</th>
                                <td>{{ $book['published_date'] ?? '未登録' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- 書籍説明 -->
            <div class="mt-4">
                <h6 class="fw-bold mb-3">書籍説明</h6>
                <div class="bg-light rounded p-3">
                    <p class="mb-0 text-break">
                        {{ $book['description'] ?? '説明は登録されていません。' }}
                    </p>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.books.edit') }}" class="btn btn-primary">
                    書籍検索ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
