@extends('layouts.general')

@section('title', '貸出申請完了')

@section('content')

    <x-home-return-link />

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">貸出申請完了</h1>
        <p class="text-secondary mb-0">
            以下の書籍の貸出申請を受け付けました。
        </p>
    </div>

    <div class="alert alert-success mb-4" role="alert">
        <strong>{{ $book['title'] }}</strong> の貸出申請が完了しました。
    </div>

    <!-- 申請した書籍 -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 fw-bold mb-0">申請した書籍</h2>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">

                <!-- 書籍画像 -->
                <div class="col-12 col-md-4">
                    <div class="bg-body-secondary rounded d-flex align-items-center justify-content-center"
                         style="min-height: 220px;">

                        @if (!empty($book->cover_image_path))
                            <img
                                src="{{ asset('storage/' . $book->cover_image_path) }}"
                                alt="{{ $book['title'] }}"
                                class="img-fluid rounded object-fit-contain p-3"
                                style="max-height: 220px;"
                            >
                        @else
                            <div class="text-center text-secondary">
                                <div class="fs-5 mb-1">書籍画像なし</div>
                                <small>画像は登録されていません</small>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- 書籍基本情報 -->
                <div class="col-12 col-md-8">

                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
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
                                申請受付済
                            </span>
                        @endif
                    </div>

                    <table class="table table-bordered align-middle mb-0">
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
        </div>

        <div class="card-footer bg-white border-top d-flex justify-content-end p-3">
            <a href="{{ route('books.detail', ['book' => $book->id]) }}" class="btn btn-primary">
                書籍詳細へ戻る
            </a>
        </div>
    </div>

@endsection