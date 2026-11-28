{{-- 2026年11月25日追加: 管理者が操作履歴を確認する画面。 --}}
@extends('layouts.admin')

@section('title', '操作履歴')

@section('content')

    <div class="mb-4">
        <h1 class="fw-bold mb-2">操作履歴</h1>
        <p class="text-secondary mb-0">
            書籍・社員・コメントに対する操作履歴を確認できます。
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-bold mb-0">履歴一覧</h2>
            <span class="text-secondary small">全{{ $activityLogs->total() }}件</span>
        </div>

        <div class="card-body p-0">
            @if ($activityLogs->isEmpty())
                <p class="text-secondary text-center my-0 p-4">
                    操作履歴はまだありません。
                </p>
            @else
                @php
                    $actionLabels = [
                        'created' => '登録',
                        'updated' => '編集',
                        'deleted' => '削除',
                    ];
                    $subjectLabels = [
                        'book' => '書籍',
                        'user' => '社員',
                        'comment' => 'コメント',
                    ];
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">日時</th>
                                <th scope="col">操作者</th>
                                <th scope="col">操作</th>
                                <th scope="col">対象</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activityLogs as $activityLog)
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $activityLog->created_at->copy()->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>
                                        {{ $activityLog->actor_name }}
                                        <span class="text-secondary small d-block">
                                            社員ID: {{ $activityLog->actor_user_id ?? '不明' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $subjectLabels[$activityLog->subject_type] ?? $activityLog->subject_type }}
                                        {{ $actionLabels[$activityLog->action] ?? $activityLog->action }}
                                    </td>
                                    <td>
                                        {{ $subjectLabels[$activityLog->subject_type] ?? $activityLog->subject_type }}
                                        ID: {{ $activityLog->subject_id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $activityLogs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

@endsection
