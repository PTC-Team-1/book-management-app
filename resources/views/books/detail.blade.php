@extends('layouts.general')

@section('title', '書籍詳細')

@section('content')
    {{-- 2026年11月27日追記: 詳細画面から共通のトップページ導線を利用する。 --}}
    <x-home-return-link />

    <!-- ページタイトル -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <h1 class="fw-bold mb-2">書籍詳細</h1>
            <p class="text-secondary mb-0">
                書籍の詳細情報を確認できます。
            </p>
        </div>
    </div>

    <!-- 書籍情報 -->
    <div class="card border-0 shadow-sm mb-5 book-detail-card">
        <div class="card-body p-4">

            <div class="row g-4">

                <!-- 書籍画像 -->
                <div class="col-12 col-md-4">
                    <div class="book-detail-image-frame rounded d-flex align-items-center justify-content-center">

                        @if (!empty($book['cover_image_path']))
                            <img
                                src="{{ asset('storage/' . $book->cover_image_path) }}"
                                alt="{{ $book['title'] }}"
                                class="book-detail-image img-fluid rounded object-fit-contain p-3"
                            >
                        @else
                            <div class="book-detail-image-placeholder rounded d-flex flex-column align-items-center justify-content-center text-center p-4">
                                <svg
                                    class="book-detail-image-placeholder-icon mb-3"
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

                    </div>
                </div>

                <!-- 書籍基本情報 -->
                <div class="col-12 col-md-8">

                    {{-- 2026年11月27日追記: 長い書名と貸出操作が横幅を奪い合わないよう、申請操作を別段に置く。 --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <h2 class="book-detail-title fw-bold mb-0">
                                {{ $book['title'] }}
                            </h2>

                            @if (optional($book->rentalStatus)->code === 'available')
                                <span class="badge bg-success">
                                    {{ $book->rentalStatus->name }}
                                </span>
                            @elseif ($book->rentalStatus)
                                <span class="badge bg-secondary">
                                    {{ $book->rentalStatus->name }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    未設定
                                </span>
                            @endif
                        </div>

                        @if ($canRequstBook)
                            <form action="/books/rental/request" method="post" class="d-inline-flex">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book['id'] }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-primary">
                                    貸出申請
                                </button>
                            </form>
                        @else
                            <span class="badge bg-warning text-dark">
                                貸出申請中
                            </span>
                        @endif
                    </div>

                    <table class="table table-bordered align-middle mb-4 book-detail-table">
                        <tbody>
                            <tr>
                                <th class="table-light" style="width: 30%;">カテゴリ</th>
                                <td>{{ optional($book->category)->name ?? '未設定' }}</td>
                            </tr>

                            <tr>
                                <th class="table-light" style="width: 30%;">著者</th>
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
                <h5 class="fw-bold mb-3">書籍説明</h5>

                <div class="book-detail-description">
                    <p class="mb-0 text-break">
                        {{ $book['description'] ?? '説明は登録されていません。' }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- コメント一覧 -->
    <section>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">コメント一覧</h3>

            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-secondary">
                    {{ $comments->count() }} 件
                </span>

                <a href="{{ route('books.comments.create', ['book' => $book->id]) }}"
                   class="btn btn-primary">
                    コメントを追加
                </a>
            </div>
        </div>

        @forelse ($comments as $comment)

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">

                    <!-- コメント投稿者・編集ボタン -->
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <div class="fw-semibold">
                            {{ $comment->user->name}}
                        </div>

                        @if (Auth::user()->id === $comment->user->id || Auth::user()->role === 'admin')
                            <div class="d-flex gap-2">
                                <a href="/books/comments/edit?comment_id={{ $comment->id }}&book_id={{ $book['id'] }}&user_id={{ $comment->user->id }}"
                                class="btn btn-outline-primary btn-sm">
                                    編集
                                </a>

                                <a href="/books/comments/erase?comment_id={{ $comment->id }}&book_id={{ $book['id'] }}&user_id=4"
                                class="btn btn-outline-danger btn-sm">
                                    削除
                                </a>
                            </div>
                        @endif

                    </div>

                    <!-- 星評価 -->
                    <div class="mb-3" aria-label="評価 {{ $comment->rating }} / 5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $comment->rating)
                                <span class="text-warning fs-5">★</span>
                            @else
                                <span class="text-secondary fs-5">☆</span>
                            @endif
                        @endfor

                        <small class="text-secondary ms-1">
                            {{ $comment->rating }} / 5
                        </small>
                    </div>
                    <div class="text-secondary small mb-3">
                        投稿日時：{{ $comment->created_at->format('Y/m/d') }}
                    </div>

                    <!-- コメント内容 -->
                    <p class="mb-0 text-break">
                        {{ $comment->content }}
                    </p>

                </div>
            </div>

        @empty

            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">

                    <h5 class="fw-bold mb-2">
                        コメントはありません
                    </h5>

                    <p class="text-secondary mb-0">
                        この書籍にはまだコメントが投稿されていません。
                    </p>

                </div>
            </div>

        @endforelse

    </section>

@endsection