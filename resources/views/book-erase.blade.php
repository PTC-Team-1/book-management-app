@extends('layouts.admin')

@section('title', '書籍削除')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍削除</h1>
        <p class="text-secondary mb-0">
            削除する書籍を検索し、内容を確認してから削除できます。
        </p>
    </div>

    @if (isset($book))

        <!-- 削除確認カード -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">削除対象の書籍</h5>
            </div>

            <div class="card-body p-4">

                <!-- 警告メッセージ -->
                <div class="alert alert-danger" role="alert">
                    <strong>注意：</strong>
                    以下の書籍を削除します。この操作は取り消せません。
                </div>

                <!-- 書籍情報 -->
                <div class="row g-4">

                    <!-- 書籍画像 -->
                    <div class="col-12 col-md-4">
                        <div class="bg-body-secondary rounded d-flex justify-content-center align-items-center p-3">

                            @if (!empty($book['thumbnail']))
                                <img
                                    src="{{ $book['thumbnail'] }}"
                                    alt="{{ $book['title'] }}"
                                    class="img-fluid object-fit-contain"
                                >
                            @else
                                <div class="text-center text-secondary py-5">
                                    <div class="fs-1 mb-2">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <small>画像は登録されていません</small>
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- 書籍詳細 -->
                    <div class="col-12 col-md-8">

                        <h4 class="fw-bold mb-4">
                            {{ $book['title'] }}
                        </h4>

                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="width: 30%;">
                                        著者
                                    </th>
                                    <td>{{ $book['author'] ?? '未登録' }}</td>
                                </tr>

                                <tr>
                                    <th class="table-light">出版社</th>
                                    <td>{{ $book['publisher'] ?? '未登録' }}</td>
                                </tr>

                                <tr>
                                    <th class="table-light">ISBN</th>
                                    <td>{{ $book['isbn'] ?? '未登録' }}</td>
                                </tr>

                                <tr>
                                    <th class="table-light">出版日</th>
                                    <td>{{ $book['published_date'] ?? '未登録' }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

                <!-- 説明文 -->
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">書籍説明</h6>

                    <div class="bg-light rounded p-3">
                        <p class="mb-0 text-break">
                            {{ $book['description'] ?? '説明は登録されていません。' }}
                        </p>
                    </div>
                </div>

                <!-- 削除ボタン -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <a href="{{ route('admin.books.delete.search') }}"
                       class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <form action="{{ route('admin.books.destroy') }}" method="POST">
                        @csrf
                        <input
                            type="hidden"
                            name="id"
                            value="{{ $book['id'] }}"
                        >

                        <button type="submit" class="btn btn-danger">
                            書籍を削除する
                        </button>
                    </form>

                </div>

            </div>
        </div>

    @else

        <!-- 書籍検索カード -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">削除する書籍を検索</h5>
            </div>

            <div class="card-body p-4">

                <p class="text-secondary mb-4">
                    削除したい書籍のIDを入力してください。
                </p>

                <form action="{{ route('admin.books.delete.search') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="id" class="form-label fw-semibold">
                            書籍ID
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="id"
                            name="id"
                            placeholder="書籍IDを入力してください"
                            value="{{ old('id') }}"
                            min="1"
                            required
                            autofocus
                        >
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            書籍を検索する
                        </button>

                    </div>

                </form>

            </div>
        </div>

    @endif

@endsection
