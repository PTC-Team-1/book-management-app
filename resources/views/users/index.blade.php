
@extends('layouts.admin')

@section('title', '社員一覧ページ')

@section('content')

    <!-- ページタイトル -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2">社員一覧</h1>
        <p class="text-secondary mb-0">
            現在登録されている社員の情報を確認できます。
        </p>
    </div>

    <!-- 社員一覧 -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">登録社員</h5>
        </div>

        <div class="card-body p-4">

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
                        現在、登録されている社員はいません。
                    </p>
                </div>

            @endforelse

        </div>
    </div>

@endsection
