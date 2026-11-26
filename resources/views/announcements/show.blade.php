{{-- 2026年11月26日追記: ホームのお知らせタイトルから遷移し、本文全体を表示。 --}}
@extends('layouts.general')

@section('title', $announcement->title)

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">トップページ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ詳細</li>
        </ol>
    </nav>

    <article class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="badge bg-info text-dark">お知らせ</span>
                <time
                    class="text-secondary small"
                    datetime="{{ $announcement->created_at->copy()->setTimezone('Asia/Tokyo')->toIso8601String() }}"
                >
                    {{ $announcement->created_at->copy()->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}
                </time>
            </div>

            <h1 class="h3 fw-bold mb-4">{{ $announcement->title }}</h1>

            <div class="bg-light rounded p-4 text-break">
                <p class="mb-0">{!! nl2br(e($announcement->body)) !!}</p>
            </div>
        </div>
    </article>

    <div class="mt-4">
        <a href="/" class="btn btn-outline-secondary">トップページへ戻る</a>
    </div>
@endsection
