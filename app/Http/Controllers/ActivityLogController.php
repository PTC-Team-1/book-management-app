<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Contracts\View\View;

class ActivityLogController extends Controller
{
    // 2026年11月25日追加: 管理者向けの操作履歴一覧を表示する。
    public function index(): View
    {
        $activityLogs = ActivityLog::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(25);

        return view('activity-logs', [
            'activityLogs' => $activityLogs,
        ]);
    }
}
