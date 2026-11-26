
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | 管理者ページ</title>

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

        <!-- ロゴ・一般ページへのリンク・ログアウト -->
        <div class="container py-2">
            <div class="header-main-row d-flex justify-content-between align-items-center py-3">

                <a href="/admin/books/create"
                   class="navbar-brand d-flex align-items-center gap-3 text-white mb-0">
                    <img src="/images/syrms-emblem-hex.png"
                         alt=""
                         class="brand-mark">
                    <span class="brand-title ps-3">
                        <img src="/images/syrms-wordmark.png"
                             alt="SYRMS CORPORATION"
                             class="brand-wordmark">
                        <span class="brand-section">書籍管理システム</span>
                    </span>
                    <span class="badge bg-info text-dark">ADMIN</span>
                </a>

                <div class="d-flex align-items-center gap-2">

                    <!-- ログインユーザー名 -->
                    <span class="admin-user-name text-white small">
                        {{ Auth::user()->name }} さん
                    </span>

                    <!-- 一般ページへのリンク -->
                    <a href="/"
                       class="btn btn-light btn-sm fw-semibold text-primary border-0 header-action header-page-action">
                        一般ページへ
                    </a>

                    <!-- ログアウト -->
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-light btn-sm header-action">
                            ログアウト
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- ナビゲーション -->
        <div class="header-nav">
            <div class="container py-2">
                <nav class="admin-navigation nav nav-pills gap-1">

                    <a href="/admin/books/create"
                       class="nav-link">
                        書籍登録
                    </a>

                    <a href="/admin/books/edit"
                       class="nav-link">
                        書籍編集
                    </a>

                    <a href="/admin/books/erase"
                       class="nav-link">
                        書籍削除
                    </a>

                    <a href="{{ route('admin.books.rentals.index') }}"
                       class="nav-link">
                        書籍貸出申請
                    </a>

                    <a href="/admin/users/create"
                       class="nav-link">
                        社員データ登録
                    </a>

                    <a href="/admin/users/edit"
                       class="nav-link">
                        社員データ編集
                    </a>

                    <a href="/admin/users/erase"
                       class="nav-link">
                        社員データ削除
                    </a>

                    <a href="/admin/users"
                       class="nav-link">
                        社員一覧
                    </a>

                    <a href="/admin/users/search"
                       class="nav-link">
                        社員検索
                    </a>
                    
                    {{-- 2026年11月25日追加: 管理者メニューに操作履歴を追加。 --}}
                    <a href="{{ route('admin.activity-logs.index') }}"
                       class="nav-link">
                        操作履歴
                    </a>
                </nav>
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
                <img src="/images/syrms-wordmark-dark.png"
                     alt="SYRMS CORPORATION"
                     class="footer-wordmark-image">
                <span class="footer-product">書籍管理システム</span>
            </div>
            <small class="footer-copyright">
                &copy; {{ date('Y') }} SYRMS Corporation
            </small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
