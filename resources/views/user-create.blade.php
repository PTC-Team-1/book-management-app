
@extends('layouts.admin')

@section('title', '社員登録')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員登録</h1>
        <p class="text-secondary mb-0">
            新しい社員の情報を入力してください。
        </p>
    </div>

    <!-- 登録フォーム -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">社員情報</h5>
        </div>

        <div class="card-body p-4">

            <form action="/admin/users/store" method="POST">
                @csrf

                <div class="row g-4">

                    <!-- 社員名 -->
                    <div class="col-12">
                        <label for="name" class="form-label fw-semibold">
                            社員名
                            <span class="badge bg-danger ms-1">必須</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="社員名を入力してください"
                            required
                        >

                        @error('name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- メールアドレス -->
                    <div class="col-12">
                        <label for="email" class="form-label fw-semibold">
                            メールアドレス
                            <span class="badge bg-danger ms-1">必須</span>
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="example@example.com"
                            required
                        >

                        @error('email')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- パスワード -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label fw-semibold">
                            パスワード
                            <span class="badge bg-danger ms-1">必須</span>
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="パスワードを入力してください"
                            required
                        >

                        @error('password')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- パスワード確認 -->
                    <div class="col-12 col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            パスワード（確認）
                            <span class="badge bg-danger ms-1">必須</span>
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="もう一度入力してください"
                            required
                        >
                    </div>

                    <!-- 権限 -->
                    <div class="col-12">
                        <label for="role" class="form-label fw-semibold">
                            権限
                            <span class="badge bg-danger ms-1">必須</span>
                        </label>

                        <select
                            class="form-select"
                            name="role"
                            id="role"
                            required
                        >
                            <option value="general" @selected(old('role', 'general') === 'general')>
                                一般社員
                            </option>
                            <option value="admin" @selected(old('role') === 'admin')>
                                管理者
                            </option>
                        </select>

                        @error('role')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- ボタン -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <a href="/admin/users" class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        社員を登録する
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection
