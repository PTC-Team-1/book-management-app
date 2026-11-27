{{-- 2026年11月26日追記: ホームのお知らせタイトルから遷移し、本文全体を表示。 --}}
@extends('layouts.general')

@section('title', $announcement->title)

@section('content')
    <x-home-return-link />

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
@endsection
