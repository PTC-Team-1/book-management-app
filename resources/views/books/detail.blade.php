@extends('layouts.general')

@section('title', '書籍詳細')

@section('content')

    <!-- パンくずリスト -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">トップページ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                書籍詳細
            </li>
        </ol>
    </nav>

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍詳細</h1>
        <p class="text-secondary mb-0">
            書籍の詳細情報を確認できます。
        </p>
    </div>

    <!-- 書籍情報 -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">

            <div class="row g-4">

                <!-- 書籍画像 -->
                <div class="col-12 col-md-4">
                    <div class="bg-body-secondary rounded d-flex align-items-center justify-content-center"
                         style="min-height: 300px;">

                        @if (!empty($book['thumbnail']))
                            <img
                                src="{{ $book['thumbnail'] }}"
                                alt="{{ $book['title'] }}"
                                class="img-fluid rounded object-fit-contain p-3"
                                style="max-height: 300px;"
                            >
                        @else
                            <div class="text-center text-secondary">
                                <div class="fs-1 mb-2">書籍画像なし</div>
                                <small>画像は登録されていません</small>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- 書籍基本情報 -->
                <div class="col-12 col-md-8">

                    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <h2 class="fw-bold mb-0">
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
                        
                        @if ($book->isAvailable() && $hasRentalRequst == false)
                            <form action="/books/rental/request" method="post">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book['id'] }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-primary">
                                    貸出申請
                                </button>
                            </form>
                        @elseif ($hasRentalRequst)
                            <span class="badge bg-warning text-dark">
                                貸出申請中
                            </span>
                        @endif
                    </div>

                    <table class="table table-bordered align-middle mb-4">
                        <tbody>
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

                <div class="bg-light rounded p-3">
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

    <!-- トップページへ戻る -->
    <div class="mt-5">
        <a href="/" class="btn btn-outline-secondary">
            トップページへ戻る
        </a>
    </div>

@endsection