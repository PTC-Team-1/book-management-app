
@extends('layouts.admin')

@section('title', '社員登録完了')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員登録完了</h1>
        <p class="text-secondary mb-0">
            新しい社員の登録が完了しました。
        </p>
    </div>

    <!-- 登録完了メッセージ -->
    <div class="alert alert-success" role="alert">
        社員情報を正常に登録しました。
    </div>

    <!-- 登録した社員の情報 -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">登録した社員</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- 社員名 -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            社員名
                        </div>
                        <div class="fw-semibold">
                            {{ $user['name'] }}
                        </div>
                    </div>
                </div>

                <!-- メールアドレス -->
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">
                            メールアドレス
                        </div>
                        <div class="fw-semibold text-break">
                            {{ $user['email'] }}
                        </div>
                    </div>
                </div>

                <!-- 権限 -->
                <div class="col-12">
                    <div class="border rounded p-3">
                        <div class="text-secondary small mb-2">
                            権限
                        </div>

                        @if ($user['role'] === 'admin')
                            <span class="badge bg-primary">
                                管理者
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                一般社員
                            </span>
                        @endif

                    </div>
                </div>

            </div>

            <!-- 戻るボタン -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    社員登録ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
