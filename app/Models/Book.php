<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function rentalStatus(): BelongsTo
    {
        return $this->belongsTo(RentalStatus::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalRequest(): HasOne
    {
        return $this->hasOne(RentalRequest::class);
    }

    public function isAvailable(): bool
    {
        return $this->rentalStatus?->code === 'available';
    }

    public function canRequestBook(): bool
    {
        // 貸出状態
        $isRentalAvailable = $this->isAvailable();
        // 貸出申請状態
        $hasRentalRequest = $this->rentalRequest()->exists();

        return $isRentalAvailable && !$hasRentalRequest;
    }

    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where(function (Builder $query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('author', 'LIKE', "%{$keyword}%");
        });
    }
}
