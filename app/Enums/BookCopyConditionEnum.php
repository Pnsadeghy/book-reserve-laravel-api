<?php

namespace App\Enums;

enum BookCopyConditionEnum
{
    public const Good = 'good';

    public const Worn = 'worn';

    public const Damaged = 'damaged';

    public static function values(): array
    {
        return [
            self::Good,
            self::Worn,
            self::Damaged,
        ];
    }
}
