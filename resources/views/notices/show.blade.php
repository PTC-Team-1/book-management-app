@extends('layouts.general')

@section('title', 'お知らせ詳細')

@section('content')

    <!-- ページヘッダー -->
    <div class="p-4 p-md-5 mb-4 rounded-3 bg-light border shadow-sm">
        <span class="badge text-bg-primary mb-2">INFORMATION</span>
        <h1 class="h3 fw-bold mb-2">お知らせ詳細</h1>
        <p class="text-secondary mb-0">
            お知らせの詳しい内容を確認できます。
        </p>
    </div>

    <!-- お知らせ本文カード -->
    <article class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4 p-md-5">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-4 border-bottom">
                <span class="badge rounded-pill text-bg-light border text-secondary">
                    お知らせ
                </span>
                <time class="text-secondary small" datetime="{{ $notice->created_at }}">
                    公開日：{{ \Carbon\Carbon::parse($notice->created_at)->format('Y.m.d') }}
                </time>
            </div>

            <h2 class="h4 fw-bold mb-4 lh-base">
                {{ $notice->title }}
            </h2>

            <div class="text-body lh-lg" style="white-space: pre-line;">{{ $notice->body }}</div>

        </div>

        <div class="card-footer bg-white border-top p-3 p-md-4">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">

                <a href="/books/notices" class="btn btn-outline-secondary btn-sm">
                    一覧に戻る
                </a>

                @if (Auth::check() && Auth::user()->role === 'admin')
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.notices.edit', ['notice' => $notice->id]) }}"
                           class="btn btn-outline-primary btn-sm">
                            編集
                        </a>

                        <form action="{{ route('admin.notices.delete', ['notice' => $notice->id]) }}"
                              method="POST"
                              class="d-inline m-0"
                              onsubmit="return confirm('このお知らせを削除しますか？');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                削除
                            </button>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </article>

@endsection