<?php

namespace Database\Factories;

use App\Enums\ReservationStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days_reserved = $this->faker->numberBetween(1, 30);
        $status = $this->faker->randomElement(ReservationStatusEnum::values());
        $started_at = null;
        $finished_at = null;

        if ($status !== ReservationStatusEnum::Pending && $status !== ReservationStatusEnum::Canceled) {
            $started_at = $this->faker->dateTimeBetween('now', '+30 days');

            if ($status !== ReservationStatusEnum::Active) {
                $finished_at = $this->faker->dateTimeBetween($started_at, '+30 days');
            }
        }

        return [
            'days_reserved' => $days_reserved,
            'status' => $status,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
        ];
    }
}
