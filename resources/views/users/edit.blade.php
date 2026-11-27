@extends('layouts.admin')
@section('title', '社員データ編集ページ')

@section('content')

    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員データ編集</h1>
        <p class="text-secondary mb-0">社員IDを入力するか一覧から選択して、社員情報を編集できます。</p>
    </div>

    @if (isset($user))

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">社員情報編集</h5>
                <small class="text-secondary">
                    社員ID:{{ $user->id }}
                </small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.users.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">社員名</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">メールアドレス</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label fw-semibold">権限</label>
                        <select class="form-select" name="role" id="role" required>
                            <option value="general" @selected(old('role', $user->role) === 'general')>一般社員</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>管理者</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between gap-2 pt-3 border-top">
                        {{-- 2026年11月26日追加: 編集中の社員を引き継いで削除確認画面へ進む。 --}}
                        <button
                            type="submit"
                            class="btn btn-outline-danger"
                            formaction="/admin/users/erase"
                            formmethod="POST"
                            formnovalidate
                        >
                            社員の削除確認へ
                        </button>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit') }}" class="btn btn-outline-secondary">
                                キャンセル
                            </a>
                            <input type="submit" class="btn btn-primary" value="社員情報更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @else

        @if (request()->filled('id'))
            <div class="alert alert-warning" role="alert">
                指定された社員ID（{{ request()->query('id') }}）の社員が見つかりませんでした。
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">編集する社員のIDを入力</h5>
            </div>

            <div class="card-body p-4">
                <p class="text-secondary mb-4">
                    編集する社員のIDを入力してください。
                </p>

                <form action="{{ route('admin.users.edit.search') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id" class="form-label fw-semibold">社員ID</label>
                        <input
                            type="number"
                            class="form-control"
                            id="id"
                            name="id"
                            min="1"
                            value="{{ old('id') }}"
                            required
                            autofocus
                        >

                        @error('id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="社員を検索">
                    </div>
                </form>
            </div>
        </div>

        <!-- 社員一覧 -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <h5 class="fw-bold mb-0">登録されている社員一覧</h5>
                    <span class="badge bg-secondary">
                        {{ isset($users) ? $users->count() . '件' : '0件' }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="list-group">
                    @forelse ($users ?? [] as $candidate)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <a
                                    href="{{ route('admin.users.edit', ['id' => $candidate->id]) }}"
                                    class="text-decoration-none text-reset flex-grow-1"
                                >
                                    <span class="d-block fw-semibold">
                                        ID: {{ $candidate->id }} ・ {{ $candidate->name }}
                                    </span>
                                    <small class="text-secondary">
                                        {{ $candidate->email }}
                                        ・権限: {{ ($candidate->role ?? '') === 'admin' ? '管理者' : '一般社員' }}
                                    </small>
                                </a>

                                <div class="d-flex flex-shrink-0 gap-2">
                                    <a
                                        href="{{ route('admin.users.edit', ['id' => $candidate->id]) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        編集
                                    </a>
                                    <form action="/admin/users/erase" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $candidate->id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-secondary py-4">
                            登録されている社員はありません。
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    @endif

@endsection