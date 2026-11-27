
@extends('layouts.auth')

@section('title', 'ログイン')

@section('content')

    <div class="container auth-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <!-- ページタイトル -->
                <div class="text-center mb-4">
                    <div class="auth-brand-lockup">
                        <img src="/images/syrms-emblem-hex.png" alt="" class="auth-logo">
                        <img src="/images/syrms-wordmark-dark.png"
                             alt="SYRMS CORPORATION"
                             class="auth-wordmark">
                    </div>
                    <div class="auth-product-heading">
                        <h1 class="fw-bold mb-2">書籍管理システム</h1>
                        <p class="text-secondary mb-0">
                            ログインしてください
                        </p>
                    </div>
                </div>

                <!-- ログインフォーム -->
                <div class="login-card card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h4 fw-bold text-center mb-4">
                            ログイン
                        </h2>

                        <form action="{{ route('login.store') }}" method="POST">
                            @csrf

                            <!-- メールアドレス -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    メールアドレス
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="example@example.com"
                                    autocomplete="username"
                                    required
                                    autofocus
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- パスワード -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    パスワード
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="パスワードを入力"
                                    autocomplete="current-password"
                                    required
                                >

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- ログイン状態を保持 -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        class="form-check-input"
                                        value="1"
                                    >

                                    <label
                                        for="remember"
                                        class="form-check-label"
                                    >
                                        ログイン状態を保持する
                                    </label>
                                </div>
                            </div>

                            <!-- ログインボタン -->
                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-lg"
                                >
                                    ログイン
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
