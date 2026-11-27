{{-- 2026年11月26日追記: 管理者がお知らせを登録・一覧確認・削除する画面。 --}}
@extends('layouts.admin')

{{-- 2026年11月27日追記: 必須表示を共通の赤いアスタリスクに揃え、入力項目の視認性を統一する。 --}}
@section('title', 'お知らせ管理')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">お知らせ管理</h1>
        <p class="text-secondary mb-0">ここで公開したお知らせは、一般ページの「LIBRARY UPDATE」に表示されます。</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">入力内容を確認してください。</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">新しいお知らせ</h2>
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        タイトル <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                    </label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        class="form-control"
                        value="{{ old('title') }}"
                        maxlength="255"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label fw-semibold">
                        本文 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                    </label>
                    <textarea
                        id="body"
                        name="body"
                        class="form-control"
                        rows="5"
                        maxlength="5000"
                        required
                    >{{ old('body') }}</textarea>
                </div>
                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">お知らせを公開</button>
                </div>
            </form>
        </div>
    </div>

    <section aria-labelledby="announcements-list-title">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 id="announcements-list-title" class="h4 fw-bold mb-0">公開中のお知らせ</h2>
            <span class="text-secondary small">全{{ $announcements->total() }}件</span>
        </div>

        @forelse ($announcements as $announcement)
            <article class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-3">
                        <div>
                            <h3 class="h5 fw-bold mb-2">{{ $announcement->title }}</h3>
                            <p class="mb-2">{{ $announcement->body }}</p>
                            <time class="text-secondary small" datetime="{{ $announcement->created_at->copy()->setTimezone('Asia/Tokyo')->toIso8601String() }}">
                                {{ $announcement->created_at->copy()->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}
                            </time>
                        </div>
                        <form
                            action="{{ route('admin.announcements.destroy', $announcement) }}"
                            method="POST"
                            onsubmit="return confirm('このお知らせを削除しますか？');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm text-nowrap">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="alert alert-light border text-secondary">
                公開中のお知らせはありません。
            </div>
        @endforelse

        {{ $announcements->links('pagination::bootstrap-5') }}
    </section>
@endsection
