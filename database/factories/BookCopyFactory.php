<?php

namespace Database\Factories;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCopy>
 */
class BookCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'status' => fake()->randomElement(BookCopyStatusEnum::availableValues()),
            'condition' => fake()->randomElement(BookCopyConditionEnum::values()),
            'is_special' => fake()->boolean(),
        ];
    }
}
