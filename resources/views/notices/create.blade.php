@extends('layouts.admin')

@section('title', 'お知らせ登録')

@section('content')

    <!-- ページヘッダー -->
    <div class="p-4 p-md-5 mb-4 rounded-3 bg-light border shadow-sm">
        <span class="badge text-bg-primary mb-2">ADMIN</span>
        <h1 class="h3 fw-bold mb-2">お知らせ登録</h1>
        <p class="text-secondary mb-0">
            新しいお知らせを作成して公開できます。
        </p>
    </div>

    <!-- 登録フォームカード -->
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

            <form action="{{ route('admin.notices.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">タイトル</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
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
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-column-reverse flex-sm-row justify-content-end align-items-sm-center gap-3 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">
                        登録
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection