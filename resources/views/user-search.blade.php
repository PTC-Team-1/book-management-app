
@extends('layouts.admin')

@section('title', '社員検索')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員検索</h1>
        <p class="text-secondary mb-0">
            社員名から社員情報を検索できます。
        </p>
    </div>

    @if (!isset($users))

        <!-- 社員検索フォーム -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">検索条件</h5>
            </div>

            <div class="card-body p-4">

                <form action="/admin/users/search" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            社員名
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="社員名を入力してください"
                            value="{{ old('name') }}"
                        >

                        @error('name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- ボタン -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">

                        <a href="/admin/users/search"
                           class="btn btn-outline-secondary">
                            クリア
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            社員を検索する
                        </button>

                    </div>

                </form>

            </div>
        </div>

    @else

        <!-- 検索結果 -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">検索結果</h5>

                    <span class="badge bg-secondary">
                        {{ $users->count() }} 件
                    </span>
                </div>
            </div>

            <div class="card-body p-4">

                <!-- 検索条件 -->
                <div class="bg-light rounded p-3 mb-4">
                    <h6 class="fw-bold mb-2">検索条件</h6>

                    <small class="text-secondary">社員名</small>
                    <div>
                        {{ request('name') ?: '指定なし' }}
                    </div>
                </div>

                @if ($users->isNotEmpty())

                    <!-- 社員一覧テーブル -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th style="width: 15%;">社員ID</th>
                                    <th style="width: 35%;">社員名</th>
                                    <th style="width: 25%;">権限</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                @else

                    <!-- 検索結果なし -->
                    <div class="text-center py-5">

                        <div class="text-secondary mb-3">
                            <i class="bi bi-search fs-1"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            該当する社員が見つかりませんでした
                        </h5>

                        <p class="text-secondary mb-0">
                            検索条件を変更して、もう一度検索してください。
                        </p>

                    </div>

                @endif

                <!-- 再検索ボタン -->
                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <a href="/admin/users/search"
                       class="btn btn-outline-secondary">
                        再検索する
                    </a>
                </div>

            </div>
        </div>

    @endif

@endsection
