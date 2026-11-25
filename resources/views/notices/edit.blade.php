@extends('layouts.admin')

@section('title', 'お知らせ編集')

@section('content')

    <!-- ページヘッダー -->
    <div class="p-4 p-md-5 mb-4 rounded-3 bg-light border shadow-sm">
        <span class="badge text-bg-primary mb-2">ADMIN</span>
        <h1 class="h3 fw-bold mb-2">お知らせ編集</h1>
        <p class="text-secondary mb-0">
            お知らせの内容を編集して更新できます。
        </p>
    </div>

    <!-- 編集フォームカード -->
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4 p-md-5">

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.notices.update', ['notice' => $notice->id]) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">タイトル</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $notice->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="body" class="form-label fw-semibold">本文</label>
                    <textarea
                        id="body"
                        name="body"
                        rows="8"
                        class="form-control @error('body') is-invalid @enderror"
                    >{{ old('body', $notice->body) }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-column-reverse flex-sm-row justify-content-between align-items-sm-center gap-3 pt-3 border-top">
                    <a href="/books/notices/{{ $notice->id }}" class="btn btn-outline-secondary btn-sm">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        更新
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection