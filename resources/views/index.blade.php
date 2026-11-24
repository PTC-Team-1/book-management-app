@extends('layouts.general')

@section('title', 'トップページ')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-3">書籍一覧</h1>

        <p class="text-secondary mb-0">
            登録されている書籍を確認できます。
        </p>

        <p class="text-secondary mt-2">
            登録書籍数：{{ count($books) }}件
        </p>
    </div>

    @if (count($books) > 0)

        <div class="row g-4">

            @foreach ($books as $book)

                <!-- 書籍カード -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        <!-- サムネイル -->
                        <div class="bg-white text-center p-3">

                            @if (!empty($book['thumbnail']))
                                <img
                                    src="{{ $book['thumbnail'] }}"
                                    alt="{{ $book['title'] }}"
                                    class="img-fluid"
                                    style="height: 200px; object-fit: contain;"
                                >
                            @else
                                <div class="d-flex justify-content-center align-items-center bg-light text-secondary"
                                     style="height: 200px;">
                                    サムネイルなし
                                </div>
                            @endif

                        </div>

                        <!-- 書籍情報 -->
                        <div class="card-body">

                            <h2 class="h5 fw-bold mb-3">
                                {{ $book['title'] }}
                            </h2>

                            <dl class="row mb-0 small">

                                <dt class="col-4 text-secondary">著者</dt>
                                <dd class="col-8">
                                    {{ $book['author'] ?? '未登録' }}
                                </dd>

                                <dt class="col-4 text-secondary">出版社</dt>
                                <dd class="col-8">
                                    {{ $book['publisher'] ?? '未登録' }}
                                </dd>

                                <dt class="col-4 text-secondary">ISBN</dt>
                                <dd class="col-8">
                                    {{ $book['isbn'] ?? '未登録' }}
                                </dd>

                                <dt class="col-4 text-secondary">出版日</dt>
                                <dd class="col-8">
                                    {{ $book['published_date'] ?? '未登録' }}
                                </dd>

                                <dt class="col-4 text-secondary">説明</dt>
                                <dd class="col-8">
                                    {{ $book['description'] ?? '未登録' }}
                                </dd>

                            </dl>

                        </div>

                        <!-- 詳細ボタン -->
                        <div class="card-footer bg-white border-0 p-3">

                            <a href="/books/{{ $book['id'] }}"
                               class="btn btn-outline-primary btn-sm w-100">
                                詳細を見る
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- 書籍が存在しない場合 -->
        <div class="alert alert-info text-center py-4">
            登録されている書籍はありません。
        </div>

    @endif

@endsection
