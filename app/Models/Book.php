<?php

namespace App\Models;

use App\Traits\VisibleScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Book extends Model
{
    use HasFactory, HasUuids, VisibleScopeTrait;

    protected $fillable = [
        'title',
        'description',
        'is_visible',
        'is_available',
    ];

    protected $attributes = [
        'is_visible' => false,
        'is_available' => false,
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'is_available' => 'boolean',
        ];
    }

    // region Scopes
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }
    // endregion

    // region Relations
    public function copies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, BookCopy::class);
    }
    // endregion
}
