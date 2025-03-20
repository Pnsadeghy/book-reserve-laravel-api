<?php

namespace App\Observers;

use App\Enums\ReservationStatusEnum;
use App\Models\Reservation;
use App\Services\BookCopyUnavailableCacheService;

class ReservationObserver
{
    public function __construct(protected BookCopyUnavailableCacheService $bookCopyUnavailableCacheService)
    {

    }

    /**
     * Handle the Reservation "created" event.
     */
    public function created(Reservation $reservation): void
    {
        // TODO calculate expiration_date if it's active
        // TODO send notification to user if it's active
    }

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
        if ($reservation->wasChanged('status')) {
            if ($reservation->status === ReservationStatusEnum::Active) {
                // TODO calculate expiration_date
            }
            else if ($reservation->is_finished) {
                $this->bookCopyUnavailableCacheService->clearCache($reservation->book_copy_id);
                // TODO check user penalty
                // TODO active next reserve request if book copy is available
            }
        }
    }
}
