<?php

namespace App\Repositories;

use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use App\Utils\Repositories\ResourceRepository;

class ReservationRepository extends ResourceRepository implements IReservationRepository
{
    protected string $modelClass = Reservation::class;
}
