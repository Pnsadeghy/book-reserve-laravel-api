<?php

namespace App\Models;

use App\Traits\VisibleModelTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasUuids, VisibleModelTrait;

    protected $fillable = [
        'title',
        'description',
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
}
