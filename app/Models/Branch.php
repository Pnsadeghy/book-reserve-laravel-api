<?php

namespace App\Models;

use App\Traits\VisibleScopeTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, HasUuids, VisibleScopeTrait;

    protected $fillable = [
        'title',
        'address',
        'is_visible',
    ];

    protected $attributes = [
        'is_visible' => false,
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    // region Relations
    public function copies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }
    // endregion
}
