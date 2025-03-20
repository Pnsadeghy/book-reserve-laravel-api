<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Branch $branch): bool
    {
        return ! $branch->reservations()->exists() && ! $branch->copies()->exists();
    }
}
