<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\BookCopy;

class BookCopyUnavailableCacheService
{
    public function isAvailable(BookCopy $bookCopy): bool
    {
        $has = cache()->has($this->getCacheKey($bookCopy));
        if (!$has) {
            $this->addCache($bookCopy);
        }
        return $has;
    }

    public function clearCache(string $bookCopyID): void
    {
        cache()->forget($this->getCacheKey($bookCopyID));
    }

    private function addCache(BookCopy $bookCopy): void
    {
        cache()->add($this->getCacheKey($bookCopy), 'unavailable', now()->addHour());
    }

    private function getCacheKey(string|BookCopy $bookCopy): string
    {
        if (!is_string($bookCopy)) {
            $bookCopy = $bookCopy->id;
        }
        return 'book_copy_unavailable:' . $bookCopy;
    }
}
