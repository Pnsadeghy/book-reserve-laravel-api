<?php

namespace App\Enums;

enum BookCopyStatusEnum
{
    public const Available = 'available';

    public const Reserved = 'reserved';

    public const Transferred = 'transferred';

    public const UnderRepair = 'under_repair';

    public const Lost = 'lost';
}
