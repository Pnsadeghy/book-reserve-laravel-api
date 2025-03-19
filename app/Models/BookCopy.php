<?php

namespace App\Models;

use App\Enums\BookCopyStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'is_visible',
        'status',
    ];

    protected $attributes = [
        'is_visible' => false,
        'status' => BookCopyStatusEnum::Available,
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'status' => BookCopyStatusEnum::class,
        ];
    }
}
