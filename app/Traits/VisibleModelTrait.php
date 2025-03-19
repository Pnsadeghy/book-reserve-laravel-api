<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait VisibleModelTrait
{
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }
}
