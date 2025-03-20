<?php

namespace App\Services;

use App\Models\Book;

class BookAvailabilityService
{
    public function checkAvailability(Book|string $book): void
    {
        if (is_string($book)) {
            $book = Book::query()->find($book);
        }

        if ($book === null) {
            return;
        }

        $book->is_available = $book->copies()->available()->visible()->exists();

        if ($book->isDirty()) {
            $book->save();
        }
    }
}
