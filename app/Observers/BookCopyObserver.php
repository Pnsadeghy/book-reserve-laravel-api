<?php

namespace App\Observers;

use App\Models\BookCopy;
use App\Services\BookAvailabilityService;

class BookCopyObserver
{
    public function __construct(protected BookAvailabilityService $bookAvailabilityService) {}

    /**
     * Handle the BookCopy "created" event.
     */
    public function created(BookCopy $bookCopy): void
    {
        $this->bookAvailabilityService->checkAvailability($bookCopy->book);
    }

    /**
     * Handle the BookCopy "updated" event.
     */
    public function updated(BookCopy $bookCopy): void
    {
        if ($bookCopy->wasChanged('status') || $bookCopy->wasChanged('is_visible')) {
            $this->bookAvailabilityService->checkAvailability($bookCopy->book);
        }
    }

    /**
     * Handle the BookCopy "deleted" event.
     */
    public function deleted(BookCopy $bookCopy): void
    {
        $this->bookAvailabilityService->checkAvailability($bookCopy->book_id);
    }
}
