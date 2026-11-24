
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | 管理者ページ</title>

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">

    <!-- ヘッダー -->
    <header class="bg-white border-bottom shadow-sm">

        <!-- ロゴ・一般ページへのリンク・ログアウト -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">

                <a href="/admin/books/create"
                   class="navbar-brand fw-bold fs-4 text-dark mb-0">
                    書籍管理システム
                    <span class="badge bg-primary ms-1">ADMIN</span>
                </a>

                <div class="d-flex align-items-center gap-3">

                    <!-- ログインユーザー名 -->
                    <span class="text-secondary small">
                        {{ Auth::user()->name }} さん
                    </span>

                    <!-- 一般ページへのリンク -->
                    <a href="/"
                       class="btn btn-outline-secondary btn-sm">
                        一般ページへ
                    </a>

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
        <div class="container pb-2">
            <nav class="nav nav-pills flex-wrap gap-1">

                <a href="/admin/books/create"
                   class="nav-link text-secondary">
                    書籍登録
                </a>

                <a href="/admin/books/edit"
                   class="nav-link text-secondary">
                    書籍編集
                </a>

                <a href="/admin/books/erase"
                   class="nav-link text-secondary">
                    書籍削除
                </a>

                <a href="/admin/books/rentals/request"
                   class="nav-link text-secondary">
                    書籍申請一覧
                </a>

                <a href="/admin/users/create"
                   class="nav-link text-secondary">
                    社員データ登録
                </a>

                <a href="/admin/users/edit"
                   class="nav-link text-secondary">
                    社員データ編集
                </a>

                <a href="/admin/users/erase"
                   class="nav-link text-secondary">
                    社員データ削除
                </a>

                <a href="/admin/users"
                   class="nav-link text-secondary">
                    社員一覧
                </a>

                <a href="/admin/users/search"
                   class="nav-link text-secondary">
                    社員検索
                </a>
            </nav>
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
