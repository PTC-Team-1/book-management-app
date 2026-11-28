<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | 書籍管理システム</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Noto+Sans+JP:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">

    <!-- ヘッダー -->
    <header class="app-header border-0 shadow-sm">

        <div class="container py-2">
            <div class="header-main-row d-flex justify-content-between align-items-center py-3">

                <a href="/"
                   class="navbar-brand d-flex align-items-center gap-1 fw-bold fs-5 mb-0">
                    <img src="/images/syrms-emblem-hex.png"
                         alt=""
                         class="brand-mark">
                    <span class="brand-title">
                        <img src="/images/syrms-wordmark.png"
                             alt="SYRMS CORPORATION"
                             class="brand-wordmark">
                        <span class="brand-section">書籍管理システム</span>
                    </span>
                </a>

                <div class="header-account-controls">

                    <!-- お知らせ -->
                    <a href="/books/notices"
                       class="text-white text-decoration-none position-relative px-1 header-notice-link"
                       title="お知らせ">
                        <!-- ベルのSVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        @if(!empty($hasUnreadNotices))
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">新着通知</span>
                            </span>
                        @endif
                    </a>

                    <!-- ログインユーザー名 -->
                    <div class="d-none d-md-flex align-items-center">
                        <span class="small text-white header-user-label">{{ Auth::user()->name }} さん</span>
                    </div>

                    @if (Auth::user()->role === 'admin')
                        <!-- 管理者ページ -->
                        <a href="/admin/books/create"
                           class="btn btn-sm fw-semibold border-0 header-action header-page-action header-page-action--admin">
                            管理者ページへ
                        </a>
                    @endif

                    <!-- ログアウト -->
                    <form action="/logout" method="POST" class="header-logout-form">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-light btn-sm header-action header-logout-action">
                            ログアウト
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- ナビゲーション -->
        <div class="header-nav">
            <div class="container py-2">
                <div class="general-navigation-controls">

                    <nav class="nav nav-underline">
                         <a href="{{ route('book-requests.index') }}"
                   class="btn btn-outline-light btn-sm fw-semibold text-nowrap header-action">
                    書籍リクエスト
                </a>
                    </nav>

                    <!-- 書籍編集用検索バー -->
                    <form action="/books/search"
                          method="GET"
                          class="header-search-form">

                        <input
                            type="text"
                            name="q"
                            class="form-control form-control-sm header-search"
                            placeholder="編集する書籍を検索"
                            value="{{ request('title') }}"
                            aria-label="書籍名"
                        >

                        <button type="submit"
                                class="btn btn-primary btn-sm fw-semibold text-nowrap px-3 header-action">
                            検索
                        </button>

                    </form>

                </div>
            </div>
        </div>

    </header>

    <!-- メインコンテンツ -->
    <main class="container py-5 grow">
        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="app-footer mt-auto">
        <div class="container py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                <img src="/images/syrms-wordmark.png"
                     alt="SYRMS CORPORATION"
                     class="footer-wordmark-image">
                <span class="footer-product">書籍管理システム</span>
            </div>
            <small class="footer-copyright">
                &copy; {{ date('Y') }} SYRMS Corporation
            </small>
        </div>
    </footer>

    <button type="button"
            class="home-scroll-top"
            aria-label="ページ上部へ戻る"
            title="ページ上部へ戻る">
        <svg xmlns="http://www.w3.org/2000/svg"
             width="20"
             height="20"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             aria-hidden="true"
             focusable="false">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    <!-- Bootstrap 5 JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        (() => {
            const button = document.querySelector('.home-scroll-top');
            if (!button) return;

            const updateVisibility = () => {
                button.classList.toggle('is-visible', window.scrollY > 320);
            };

            window.addEventListener('scroll', updateVisibility, { passive: true });
            updateVisibility();

            button.addEventListener('click', () => {
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                window.scrollTo({
                    top: 0,
                    behavior: reduceMotion ? 'auto' : 'smooth'
                });
            });
        })();
    </script>

</body>
</html>