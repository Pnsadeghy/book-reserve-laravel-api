<?php

namespace App\Services;

use App\Enums\BookCopyStatusEnum;
use App\Enums\ReservationStatusEnum;
use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use App\Models\BookCopy;

class UserReservationService
{
    public function __construct(protected IReservationRepository $repository,
    protected BookCopyUnavailableCacheService $bookCopyUnavailableCacheService,
    protected BookAvailabilityService $bookAvailabilityService)
    {

    }

    public function add($user, BookCopy $bookCopy, int $days): Reservation
    {
        $available = $bookCopy->is_available && $this->bookCopyUnavailableCacheService->isAvailable($bookCopy);
        if ($available) {
            $updatedRows = BookCopy::query()->where('id', $bookCopy->id)
                ->where('status', BookCopyStatusEnum::Available)
                ->update([
                    'status' => BookCopyStatusEnum::Reserved,
                    'updated_at' => now()
                ]);

            $available = $updatedRows > 0;

            if ($available) {
                $bookCopy->refresh();
                $this->bookAvailabilityService->checkAvailability($bookCopy);
            }
        }

        return $this->repository->store([
            'user_id' => $user->id,
            'book_copy_id' => $bookCopy->id,
            'branch_id' => $bookCopy->branch_id,
            'days_reserved' => $days,
            'status' => $available ? ReservationStatusEnum::Active : ReservationStatusEnum::Pending
        ]);
    }
}
