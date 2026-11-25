
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | 書籍管理システム</title>

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">

    <!-- ヘッダー -->
    <header class="bg-white border-bottom shadow-sm">

        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">

                <a href="/"
                   class="navbar-brand fw-bold fs-4 text-dark mb-0">
                    書籍管理システム
                </a>

                <div class="d-flex align-items-center gap-3">
                    <!-- お知らせ -->
                    <a href="/books/notices" class="text-dark text-decoration-none position-relative" title="お知らせ">
                        <!-- ベルのSVG -->
                        <svg xmlns="http://w3.org" width="22" height="22" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        @if(!empty($hasUnreadNotices))
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">新着通知</span>
                            </span>
                        @endif
                    </a>
                    <!-- ログインユーザー名 -->
                    <span class="text-secondary small">
                        {{ Auth::user()->name }} さん
                    </span>
                    
                    @if (Auth::user()->role === 'admin')
                        <!-- 管理者ページ -->
                        <a href="/admin/books/create"
                        class="btn btn-outline-primary btn-sm">
                            管理者ページへ
                        </a>
                    @endif

                    <!-- ログアウト -->
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-danger btn-sm">
                            ログアウト
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- ナビゲーション -->
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pb-3">

                <nav class="nav nav-underline">
                    <a href="/"
                       class="nav-link active text-primary"
                       aria-current="page">
                        トップページ
                    </a>
                </nav>

                <!-- 書籍編集用検索バー -->
                <form action="/books/search"
                      method="GET"
                      class="d-flex gap-2">

                    <input
                        type="text"
                        name="title"
                        class="form-control form-control-sm"
                        placeholder="編集する書籍を検索"
                        value="{{ request('title') }}"
                        aria-label="書籍名"
                    >

                    <button type="submit"
                            class="btn btn-primary btn-sm text-nowrap">
                        検索
                    </button>

                </form>

            </div>
        </div>

    </header>

    <!-- メインコンテンツ -->
    <main class="container py-5 grow">
        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center">
            <small class="text-secondary">
                &copy; {{ date('Y') }} 書籍管理システム
            </small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
