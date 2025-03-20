<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationObserver
{
    /**
     * Handle the Reservation "updating" event.
     */
    public function updating(Reservation $reservation): void
    {
        if ($reservation->isDirty('status') && $reservation->is_finished) {
            $reservation->finished_at = now();
        }
    }

    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void
    {
        if ($reservation->wasChanged('status') && $reservation->is_finished) {
            // TODO check book copy availability
        }
    }
}
