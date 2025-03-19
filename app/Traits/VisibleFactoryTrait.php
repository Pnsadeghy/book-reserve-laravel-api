<?php

namespace App\Traits;

trait VisibleFactoryTrait
{
    public function unvisible(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'visible' => false,
            ];
        });
    }
}
