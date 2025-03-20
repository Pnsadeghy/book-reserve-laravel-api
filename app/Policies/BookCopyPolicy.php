<?php

namespace App\Policies;

use App\Models\BookCopy;
use App\Models\User;

class BookCopyPolicy
{
    /**
     * Determine whether the user can reserve the model.
     */
    public function reserve(User $user, BookCopy $bookCopy): bool
    {
        return $bookCopy->is_visible;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BookCopy $bookCopy): bool
    {
        return ! $bookCopy->reservations()->exists();
    }
}
