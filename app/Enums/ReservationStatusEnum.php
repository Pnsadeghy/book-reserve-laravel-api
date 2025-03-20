<?php

namespace App\Enums;

enum ReservationStatusEnum
{
    public const Pending = 'pending';

    public const Active = 'active';

    public const Completed = 'completed';

    public const Canceled = 'cancelled';

    public const NotReturned = 'not_returned';
}
