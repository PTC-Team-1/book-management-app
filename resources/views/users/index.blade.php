
@extends('layouts.admin')

@section('title', '社員一覧')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員一覧</h1>
        <p class="text-secondary mb-0">
            社員情報の確認と、社員名による絞り込みができます。
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">登録社員</h5>
            <span class="badge bg-secondary">{{ $users->count() }} 件</span>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.users.index') }}" method="GET" class="employee-search-form row g-2 align-items-end mb-4">
                <div class="col-12 col-md">
                    <label for="employee-name" class="form-label fw-semibold">社員名で検索</label>
                    <input
                        type="search"
                        class="form-control"
                        id="employee-name"
                        name="name"
                        value="{{ $name }}"
                        placeholder="社員名を入力"
                    >
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">検索</button>
                    @if ($name !== '')
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">クリア</a>
                    @endif
                </div>
            </form>

            @forelse ($users as $user)

                <div class="border rounded p-3 mb-3">

                    <div class="row g-3 align-items-center">

                        <div class="col-12 col-md-5">
                            <div class="text-secondary small mb-1">
                                社員名
                            </div>
                            <div class="fw-semibold">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="col-12 col-md-5">
                            <div class="text-secondary small mb-1">
                                メールアドレス
                            </div>
                            <div class="text-break">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <div class="text-secondary small mb-1">
                                権限
                            </div>

                            @if ($user->role === 'admin')
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

            @empty

                <div class="text-center py-5">
                    <p class="text-secondary mb-0">
                        {{ $name !== '' ? '該当する社員が見つかりませんでした。検索条件を変更してください。' : '現在、登録されている社員はいません。' }}
                    </p>
                </div>

            @endforelse

        </div>
    </div>

@endsection
