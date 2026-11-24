
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
