@extends('layouts.admin')

@section('title', '貸出申請一覧')

@section('content')

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
                    <table class="table table-bordered align-middle mb-0 rental-request-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 28%;">書籍名</th>
                                <th style="width: 18%;">申請者</th>
                                <th style="width: 14%;">貸出状況</th>
                                <th style="width: 18%;">申請日時</th>
                                <th class="col-actions">操作</th>
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

                                    <td class="col-actions">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <form action="{{ route('admin.books.rentals.approve') }}" method="post" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="rental_request_id" value="{{ $rentalRequest->id }}">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    許可
                                                </button>
                                            </form>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    aria-label="却下（未実装）"
                                                    title="却下機能は未実装です"
                                                    disabled>
                                                却下
                                            </button>
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

@endsection