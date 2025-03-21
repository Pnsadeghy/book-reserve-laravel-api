<?php

namespace App\Enums;

enum ReservationStatusEnum
{
    public const Pending = 'pending';

    public const Active = 'active';

    public const Completed = 'completed';

    public const Canceled = 'cancelled';

    public const NotReturned = 'not_returned';

    public static function values(): array
    {
        return [
            self::Pending,
            self::Active,
            self::Completed,
            self::Canceled,
            self::NotReturned,
        ];
    }

    public static function finishValues(): array
    {
        return [
            self::Completed,
            self::Canceled,
            self::NotReturned,
        ];
    }
}
