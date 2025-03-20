<?php

namespace App\Repositories;

use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use App\Utils\Repositories\ResourceRepository;

class ReservationRepository extends ResourceRepository implements IReservationRepository
{
    protected string $modelClass = Reservation::class;

    public function includeBookCopy(): IReservationRepository
    {
        $this->model = $this->model->with(['bookCopy', 'bookCopy.book']);

        return $this;
    }

    public function includeBranch(): IReservationRepository
    {
        $this->model = $this->model->with('branch');

        return $this;
    }

    public function includeUser(): IReservationRepository
    {
        $this->model = $this->model->with('user');

        return $this;
    }
}
