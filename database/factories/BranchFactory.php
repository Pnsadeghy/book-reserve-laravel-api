<?php

namespace Database\Factories;

use App\Traits\VisibleFactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    use VisibleFactoryTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->words(1, true),
            'address' => $this->faker->unique()->words(2, true),
        ];
    }
}
