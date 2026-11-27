@extends('layouts.general')

@section('title', 'お知らせ一覧')

@section('content')
    {{-- 2026年11月27日追記: お知らせ一覧から共通のトップページ導線を利用する。 --}}
    <x-home-return-link />

    <!-- ページヘッダー -->
    <div class="p-4 p-md-5 mb-4 rounded-3 bg-light border shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="badge text-bg-primary mb-2">INFORMATION</span>
                <h1 class="h3 fw-bold mb-2">お知らせ一覧</h1>
                <p class="text-secondary mb-0">
                    最新のお知らせや重要連絡を確認できます。
                </p>
            </div>
            <div class="text-md-end">
                <div class="text-secondary small">掲載件数</div>
                <div class="fs-4 fw-bold text-primary">{{ count($notices) }}<span class="fs-6 fw-normal text-secondary ms-1">件</span></div>
            </div>
        </div>
    </div>

    @if (count($notices) > 0)

        <div class="row g-4">

            @foreach ($notices as $notice)

                <!-- お知らせカード -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge rounded-pill text-bg-light border text-secondary">
                                    お知らせ
                                </span>
                                <time class="text-secondary small" datetime="{{ $notice->created_at }}">
                                    {{ \Carbon\Carbon::parse($notice->created_at)->format('Y.m.d') }}
                                </time>
                            </div>

                            <h2 class="h5 fw-bold mb-3 lh-base">
                                <a href="/books/notices/{{ $notice->id }}" class="text-decoration-none text-dark">
                                    {{ $notice->title }}
                                </a>
                            </h2>

                            @if (!empty($notice->body))
                                <p class="text-secondary small mb-0 mt-auto" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $notice->body }}
                                </p>
                            @endif

                        </div>

                        <!-- 詳細ボタン -->
                        <div class="card-footer bg-white border-0 p-3">

                            <a href="{{ route('notices.detail', ['notice' => $notice->id]) }}"
                               class="btn btn-outline-primary btn-sm w-100">
                                詳細を見る
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- お知らせが存在しない場合 -->
        <div class="card border-0 shadow-sm text-center py-5 px-3 bg-light">
            <div class="card-body">
                <p class="h6 fw-bold text-secondary mb-2">現在お知らせはありません</p>
                <p class="text-secondary small mb-0">新しいお知らせが公開されるとこちらに表示されます。</p>
            </div>
        </div>

    @endif

@endsection