@extends('layouts.admin')

@section('title', '書籍リクエスト管理')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">書籍リクエスト管理</h1>
        <p class="text-secondary mb-0">社員から届いたリクエストの対応状況を管理できます。</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-bold mb-0">リクエスト一覧</h2>
            <span class="text-secondary small">全{{ $bookRequests->total() }}件</span>
        </div>
        <div class="card-body p-0">
            @if ($bookRequests->isEmpty())
                <p class="text-secondary text-center p-4 mb-0">リクエストはまだありません。</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 book-request-admin-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">申請内容</th>
                                <th scope="col">対応状況・コメント</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookRequests as $bookRequest)
                                <tr>
                                    <td>
                                        <div class="book-request-heading-row">
                                            <h3 class="h6 fw-bold mb-0">{{ $bookRequest->title }}</h3>
                                            <span class="badge rounded-pill bg-light text-secondary border book-request-requester">
                                                申請者: {{ $bookRequest->user->name }}
                                            </span>
                                        </div>
                                        @if ($bookRequest->author || $bookRequest->isbn)
                                            <div class="book-request-meta small">
                                                @if ($bookRequest->author)
                                                    <span><strong>著者:</strong> {{ $bookRequest->author }}</span>
                                                @endif
                                                @if ($bookRequest->isbn)
                                                    <span><strong>ISBN:</strong> {{ $bookRequest->isbn }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($bookRequest->reason)
                                            <p class="book-request-reason small mb-2">
                                                <strong>理由:</strong> {{ $bookRequest->reason }}
                                            </p>
                                        @endif
                                        <div class="book-request-footer small">
                                            <time datetime="{{ $bookRequest->created_at->toIso8601String() }}">
                                                {{ $bookRequest->created_at->copy()->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}
                                            </time>
                                            <span class="text-primary">いいね: {{ $bookRequest->likes_count }}人</span>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.book-requests.update', $bookRequest) }}"
                                            method="POST" class="book-request-admin-actions">
                                            @csrf
                                            @method('PATCH')
                                            <label class="visually-hidden" for="status-{{ $bookRequest->id }}">
                                                {{ $bookRequest->title }}の対応状況
                                            </label>
                                            <select id="status-{{ $bookRequest->id }}" name="status" class="form-select form-select-sm">
                                                @foreach ($statuses as $value => $label)
                                                    <option value="{{ $value }}" @selected($bookRequest->status === $value)>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label class="visually-hidden" for="admin-note-{{ $bookRequest->id }}">
                                                {{ $bookRequest->title }}へのコメント
                                            </label>
                                            <textarea id="admin-note-{{ $bookRequest->id }}" name="admin_note"
                                                class="form-control form-control-sm" rows="2" maxlength="2000"
                                                placeholder="申請者へのコメント">{{ $bookRequest->admin_note }}</textarea>
                                            <button type="submit" class="btn btn-primary btn-sm book-request-save-button">状況を保存</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $bookRequests->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
