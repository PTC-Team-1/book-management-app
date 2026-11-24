
@extends('layouts.admin')

@section('title', '書籍登録完了')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍登録完了</h1>
        <p class="text-secondary mb-0">
            新しい書籍の登録が完了しました。
        </p>
    </div>

    <!-- 登録完了メッセージ -->
    <div class="alert alert-success" role="alert">
        書籍情報を正常に登録しました。
    </div>

    <!-- 登録した書籍の情報 -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">登録した書籍</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- 書籍名 -->
                <div class="col-12">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            書籍名
                        </div>
                        <div class="fw-semibold">
                            {{ $book['title'] }}
                        </div>
                    </div>
                </div>

                <!-- 著者名 -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            著者名
                        </div>
                        <div class="fw-semibold">
                            {{ $book['author'] ?? '未登録' }}
                        </div>
                    </div>
                </div>

                <!-- 出版社 -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            出版社
                        </div>
                        <div class="fw-semibold">
                            {{ $book['publisher'] ?? '未登録' }}
                        </div>
                    </div>
                </div>

                <!-- ISBN -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            ISBN
                        </div>
                        <div class="fw-semibold">
                            {{ $book['isbn'] ?? '未登録' }}
                        </div>
                    </div>
                </div>

                <!-- 出版日 -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            出版日
                        </div>
                        <div class="fw-semibold">
                            {{ $book['published_date'] ?? '未登録' }}
                        </div>
                    </div>
                </div>

                <!-- 説明文 -->
                <div class="col-12">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            説明文
                        </div>
                        <div class="fw-semibold text-break"
                             style="white-space: pre-wrap;">{{ $book['description'] ?? '未登録' }}</div>
                    </div>
                </div>

                <!-- 書籍画像 -->
                <div class="col-12">
                    <div class="border rounded p-3">
                        <div class="text-secondary small mb-3">
                            書籍画像
                        </div>

                        @if (!empty($book['thumbnail']))
                            <img
                                src="{{ $book['thumbnail'] }}"
                                alt="{{ $book['title'] }}"
                                class="img-thumbnail"
                                style="max-width: 200px; max-height: 280px; object-fit: contain;"
                            >
                        @else
                            <div class="text-secondary">
                                未登録
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="/admin/books/create" class="btn btn-primary">
                    書籍登録ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
