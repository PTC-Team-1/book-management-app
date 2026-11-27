@extends('layouts.general')

@section('title', 'トップページ')

@section('content')
<section class="news-panel mb-5" aria-labelledby="news-title">
        <div class="news-heading">
            <span class="news-eyebrow">LIBRARY UPDATE</span>
            <h2 class="news-title" id="news-title">NEWS</h2>
            <p class="news-description">お知らせ</p>
        </div>

        <div class="news-list">
            @forelse ($news as $item)
                <div class="news-item">
                    <time class="news-date" datetime="{{ $item['created_at']->copy()->setTimezone('Asia/Tokyo')->toDateString() }}">
                        {{ $item['created_at']->copy()->setTimezone('Asia/Tokyo')->format('Y.m.d') }}
                    </time>
                    @if ($item['type'] === 'announcement')
                        <div class="news-item-content">
                            <span class="badge bg-info text-dark mb-1">お知らせ</span>
                            <h3 class="news-item-title mb-1">
                                <a href="{{ route('announcements.show', $item['id']) }}" class="news-item-title">
                                    {{ $item['title'] }}
                                </a>
                            </h3>
                        </div>
                    @else
                        <div class="news-item-content d-flex flex-wrap align-items-center gap-2">
                            <span class="badge bg-danger">新着</span>
                            <a href="/books/{{ $item['id'] }}" class="news-item-title">
                                「{{ $item['title'] }}」が追加されました
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p class="news-empty mb-0">現在お知らせはありません。</p>
            @endforelse
        </div>
    </section>

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
                            <div class="d-flex justify-content-center align-items-center"
                                style="height: 200px;">

                                @if (!empty($book->cover_image_path))
                                    <img
                                        src="{{ asset('storage/' . $book->cover_image_path) }}"
                                        alt="{{ $book->title }}"
                                        class="img-fluid"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                    >
                                @else
                                    <div class="book-thumbnail-placeholder d-flex justify-content-center align-items-center bg-light text-secondary">
                                        サムネイルなし
                                    </div>
                                @endif

                            </div>
                        </div>

                        <!-- 書籍情報 -->
                        <div class="card-body">

                            <h2 class="h5 fw-bold mb-3">
                                {{ $book['title'] }}
                            </h2>

                            <dl class="row mb-0 small">
                                <dt class="col-4 text-secondary">カテゴリ</dt>
                                <dd class="col-8">
                                    {{ $book->category->name }}
                                </dd>
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

                            <a href="{{ route('books.detail', ['book' => $book->id]) }}"
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
