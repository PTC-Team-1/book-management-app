@extends('layouts.general')

@section('title', 'トップページ')

@section('content')
<div class="home-page-content">
<section class="news-panel mb-5" aria-labelledby="news-title">
        <div class="news-heading">
            <span class="news-eyebrow">LIBRARY UPDATE</span>
            <h2 class="news-title" id="news-title">NEWS</h2>
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
                        <div class="news-item-content">
                            <span class="badge bg-danger mb-1">新着</span>
                            <a href="/books/{{ $item['id'] }}" class="news-item-title d-block">
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

    <section class="catalog-heading mb-4" aria-labelledby="catalog-title">
        <div>
            <h1 class="h3 fw-bold mb-2" id="catalog-title">書籍一覧</h1>
            <p class="text-secondary mb-0">登録されている書籍を確認できます。</p>
        </div>
        <div class="catalog-count" aria-label="登録書籍数">
            <span class="catalog-count-label">登録書籍数</span>
            <div class="catalog-count-value">
                <strong>{{ count($books) }}</strong>
                <span>冊</span>
            </div>
        </div>
    </section>

    @if (count($books) > 0)

        <div class="row g-4">

            @foreach ($books->sortByDesc('created_at') as $book)

                <!-- 書籍カード -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm book-catalog-card">

                        <!-- サムネイル -->
                        <div class="book-catalog-cover-stage">
                            <a href="{{ route('books.detail', ['book' => $book->id]) }}"
                               class="book-card-cover-link d-flex justify-content-center align-items-center text-decoration-none"
                               aria-label="{{ $book->title }}の詳細を見る">

                                @if (!empty($book->cover_image_path))
                                    <img
                                        src="{{ asset('storage/' . $book->cover_image_path) }}"
                                        alt="{{ $book->title }}"
                                        class="book-catalog-cover-image img-fluid"
                                    >
                                @else
                                    <div class="book-thumbnail-placeholder home-book-thumbnail-placeholder d-flex flex-column justify-content-center align-items-center gap-2 w-100 h-100 rounded">
                                        <svg
                                            class="home-book-thumbnail-placeholder-icon"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            aria-hidden="true"
                                            focusable="false"
                                        >
                                            <path d="M12 6.5c-1.6-1.1-3.3-1.6-5.3-1.6H4v13.8h3c2 0 3.8.5 5 1.5 1.2-1 3-1.5 5-1.5h3V4.9h-2.7c-2 0-3.7.5-5.3 1.6Z"/>
                                            <path d="M12 6.5v13.7"/>
                                        </svg>
                                        <span class="small fw-medium text-nowrap">書籍画像なし</span>
                                    </div>
                                @endif

                            </a>
                            <span class="book-catalog-category">{{ $book->category->name }}</span>
                        </div>

                        <!-- 書籍情報 -->
                        <div class="card-body book-catalog-card-body">

                            <h2 class="fw-bold mb-2 book-catalog-card-title">
                                <a href="{{ route('books.detail', ['book' => $book->id]) }}"
                                   class="book-card-title-link">
                                    {{ $book['title'] }}
                                </a>
                            </h2>

                            <p class="book-catalog-byline mb-2">
                                {{ $book['author'] ?? '未登録' }}
                                <span aria-hidden="true">/</span>
                                {{ $book['publisher'] ?? '未登録' }}
                            </p>
                            <p class="book-catalog-description small mb-0">
                                {{ $book['description'] ?? '未登録' }}
                            </p>

                        </div>

                        <!-- 詳細ボタン -->
                        <div class="card-footer bg-white book-catalog-card-footer">

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
</div>

@endsection
