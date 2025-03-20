<?php

namespace App\Observers;

use App\Models\BookCopy;
use App\Services\BookAvailabilityService;
use Illuminate\Support\Facades\Log;

class BookCopyObserver
{
    public function __construct(protected BookAvailabilityService $bookAvailabilityService)
    {

    }

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
        if ($bookCopy->wasChanged("status")) {
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
