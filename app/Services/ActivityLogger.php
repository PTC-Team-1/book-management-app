<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;

// 2026年11月25日追加: 操作者と対象をひも付けて操作履歴を保存する。
class ActivityLogger
{
    public function record(User $actor, string $action, string $subjectType, int $subjectId): void
    {
        $activityLog = new ActivityLog;
        $activityLog->actor_id = $actor->id;
        $activityLog->actor_user_id = $actor->id;
        $activityLog->actor_name = $actor->name;
        $activityLog->action = $action;
        $activityLog->subject_type = $subjectType;
        $activityLog->subject_id = $subjectId;
        $activityLog->save();
    }
}
