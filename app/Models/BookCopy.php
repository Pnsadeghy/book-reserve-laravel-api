<?php

namespace App\Models;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use App\Observers\BookCopyObserver;
use App\Traits\VisibleScopeTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([BookCopyObserver::class])]
class BookCopy extends Model
{
    use HasFactory, HasUuids, VisibleScopeTrait;

    protected $fillable = [
        'title',
        'is_visible',
        'status',
        'condition',
        'is_special',
    ];

    protected $attributes = [
        'is_visible' => false,
        'is_special' => false,
        'status' => BookCopyStatusEnum::Available,
        'condition' => BookCopyConditionEnum::Good,
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'is_special' => 'boolean',
        ];
    }

    // region Scopes
    public function scopeAvailable(Builder $query): void
    {
        $query->where('status', BookCopyStatusEnum::Available);
    }
    // endregion

    // region Relations
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    // endregion
}
