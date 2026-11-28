@extends('layouts.auth')

@section('title', 'ログイン')

@section('content')

    <div class="container auth-container">
        {{-- 2026年11月27日追記: site.cssの認証画面レイアウトに合わせ、左右パネルを配置する。 --}}
        <div class="auth-split-card">
            <section class="auth-brand-panel" aria-label="書籍管理システム">
                <div class="auth-product-heading">
                    <div class="auth-company-brand">
                        <img src="/images/syrms-emblem-hex.png"
                             alt=""
                             class="auth-company-symbol">
                        <img src="/images/syrms-wordmark.png"
                             alt="SYRMS CORPORATION"
                             class="auth-company-logo">
                    </div>
                    <h1>書籍管理システム</h1>
                </div>
            </section>

            <section class="auth-login-panel" aria-labelledby="login-heading">
                <div class="auth-login-content">
                    <h2 id="login-heading" class="h4 fw-bold text-center">
                        ログイン
                    </h2>

                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf

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

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                パスワード
                            </label>
                            <div class="password-input-wrap">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="パスワードを入力"
                                    autocomplete="current-password"
                                    required
                                >
                                <button
                                    type="button"
                                    id="password-toggle"
                                    class="password-toggle"
                                    aria-label="パスワードを表示"
                                    aria-controls="password"
                                    aria-pressed="false"
                                >
                                    <svg class="password-icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.8"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
                                    </svg>
                                    <svg class="password-icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path d="m3 3 18 18M10.6 6.2A10.7 10.7 0 0 1 12 6c6.4 0 10 6 10 6a13.4 13.4 0 0 1-3.1 3.7M6.2 6.2C3.5 8 2 12 2 12s3.6 6 10 6c1.4 0 2.7-.3 3.8-.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    class="form-check-input"
                                    value="1"
                                >
                                <label for="remember" class="form-check-label">
                                    ログイン状態を保持する
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                ログイン
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');

        passwordToggle.addEventListener('click', () => {
            const isVisible = passwordInput.type === 'text';

            passwordInput.type = isVisible ? 'password' : 'text';
            passwordToggle.setAttribute('aria-pressed', String(!isVisible));
            passwordToggle.setAttribute(
                'aria-label',
                isVisible ? 'パスワードを表示' : 'パスワードを隠す'
            );
            passwordToggle.classList.toggle('is-visible', !isVisible);
        });
    </script>

@endsection
