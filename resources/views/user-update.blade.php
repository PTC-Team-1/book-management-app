
@extends('layouts.admin')

@section('title', '社員データ編集結果')

@section('content')

    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員データ編集完了</h1>
        <p class="text-secondary mb-0">以下の社員データの編集を行いました。</p>
    </div>

    <div class="alert alert-success" role="alert">
        社員情報を正常に更新しました。
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">更新した社員情報</h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-3">

                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">社員名</div>
                        <div class="fw-semibold">{{ $user['name'] }}</div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-secondary small mb-2">メールアドレス</div>
                        <div class="fw-semibold text-break">{{ $user['email'] }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="border rounded p-3">
                        <div class="text-secondary small mb-2">権限</div>
                        <div class="fw-semibold">{{ $user['role'] }}</div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="/admin/users/edit" class="btn btn-primary">
                    社員検索ページへ戻る
                </a>
            </div>

        </div>
    </div>

@endsection
