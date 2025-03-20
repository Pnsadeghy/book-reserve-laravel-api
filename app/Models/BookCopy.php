<?php

namespace App\Models;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use App\Traits\VisibleScopeTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookCopy extends Model
{
    use HasFactory, HasUuids, VisibleScopeTrait;

    protected $fillable = [
        'title',
        'is_visible',
        'status',
        'condition',
    ];

    protected $attributes = [
        'is_visible' => false,
        'status' => BookCopyStatusEnum::Available,
        'condition' => BookCopyConditionEnum::Good,
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

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
