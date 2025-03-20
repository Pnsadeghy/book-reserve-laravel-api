<?php

namespace App\Policies;

use App\Enums\ReservationStatusEnum;
use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    /**
     * Determine whether the user can complete the model.
     */
    public function complete(User $user, Reservation $reservation): bool
    {
        return $reservation->status === ReservationStatusEnum::Active;
    }

    /**
     * Determine whether the user can return the model.
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        return $reservation->status === ReservationStatusEnum::Pending;
    }
}
