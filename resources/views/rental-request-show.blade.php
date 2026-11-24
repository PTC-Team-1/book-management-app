@extends('layouts.admin')

@section('title', '貸出申請一覧')

@section('content')

    <!-- パンくずリスト -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">トップページ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                貸出申請一覧
            </li>
        </ol>
    </nav>

    <!-- ページタイトル -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-2">貸出申請一覧</h1>
            <p class="text-secondary mb-0">
                登録されている貸出申請の一覧を確認できます。
            </p>
        </div>

        <span class="badge bg-secondary fs-6">
            {{ $rentalRequests->count() }} 件
        </span>
    </div>

    <!-- フラッシュメッセージ -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- 申請一覧 -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if ($rentalRequests->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 28%;">書籍名</th>
                                <th style="width: 18%;">申請者</th>
                                <th style="width: 14%;">貸出状況</th>
                                <th style="width: 18%;">申請日時</th>
                                <th style="width: 22%;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentalRequests as $rentalRequest)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            <a href="{{ route('books.detail', ['book' => $rentalRequest->book->id]) }}">
                                                {{ optional($rentalRequest->book)->title }}
                                            </a>
                                        </div>
                                        @if ($rentalRequest->book?->author)
                                            <small class="text-secondary">
                                                {{ $rentalRequest->book->author }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $rentalRequest->user->name}}
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ $rentalRequest->book->rentalStatus->name }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $rentalRequest->created_at->format('Y/m/d H:i') }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <form action="{{ route('admin.books.rentals.approve') }}" method="post" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="rental_request_id" value="{{ $rentalRequest->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    許可する
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h5 class="fw-bold mb-2">
                        貸出申請はありません
                    </h5>
                    <p class="text-secondary mb-0">
                        現在表示できる貸出申請データはありません。
                    </p>
                </div>
            @endif

        </div>
    </div>

    <!-- トップページへ戻る -->
    <div class="mt-5">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            トップページへ戻る
        </a>
    </div>

@endsection