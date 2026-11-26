<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'author', 'isbn', 'reason'])]
class BookRequest extends Model
{
    public const STATUSES = [
        'pending' => '未確認',
        'reviewing' => '検討中',
        'purchased' => '購入済み',
        'declined' => '見送り',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(BookRequestLike::class);
    }
}
