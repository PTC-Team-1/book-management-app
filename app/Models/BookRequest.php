<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'author', 'isbn', 'reason'])]
class BookRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWING = 'reviewing';
    public const STATUS_PURCHASED = 'purchased';
    public const STATUS_DECLINED = 'declined';

    public const STATUSES = [
        self::STATUS_PENDING => '未確認',
        self::STATUS_REVIEWING => '検討中',
        self::STATUS_PURCHASED => '購入済み',
        self::STATUS_DECLINED => '見送り',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(BookRequestLike::class);
    }

    public function isPurchased(): bool
    {
        return $this->status === self::STATUS_PURCHASED;
    }
}
