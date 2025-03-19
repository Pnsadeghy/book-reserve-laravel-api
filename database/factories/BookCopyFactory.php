<?php

namespace Database\Factories;

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
            'title' => $this->faker->unique()->words(1, true),
            'status' => $this->faker->randomElement(
                [
                    BookCopyStatusEnum::Available,
                    BookCopyStatusEnum::Transferred,
                    BookCopyStatusEnum::UnderRepair,
                    BookCopyStatusEnum::Lost,
                ]
            ),
        ];
    }
}
