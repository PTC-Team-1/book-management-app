
@extends('layouts.admin')
@section('title', '社員データ削除ページ')

@section('content')

    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員データ削除</h1>
        <p class="text-secondary mb-0">
            削除する社員を検索し、内容を確認してから削除できます。
        </p>
    </div>

    @if (@isset($user))

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">削除対象の社員</h5>
            </div>

            <div class="card-body p-4">

                <div class="alert alert-danger" role="alert">
                    この社員データを削除します。この操作は取り消せません。
                </div>

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

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <a href="/admin/users/erase" class="btn btn-outline-secondary">
                        キャンセル
                    </a>

                    <form action="/admin/users/delete" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user['id'] }}">

                        <input
                            type="submit"
                            class="btn btn-danger"
                            value="社員データを削除"
                        >
                    </form>

                </div>

            </div>
        </div>

    @else

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">社員検索</h5>
            </div>

            <div class="card-body p-4">

                <p class="text-secondary mb-4">
                    削除したい社員のIDを入力してください。
                </p>

                <form action="/admin/users/erase" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id" class="form-label fw-semibold">
                            社員ID
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="id"
                            name="id"
                            min="1"
                            required
                            autofocus
                            placeholder="社員IDを入力してください"
                        >
                    </div>

                    <div class="d-flex justify-content-end">
                        <input
                            type="submit"
                            class="btn btn-primary"
                            value="社員情報検索"
                        >
                    </div>

                </form>

            </div>
        </div>

    @endif

@endsection
