<?php

namespace App\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IReservationRepository extends IResourceRepository
{
    public function includeBookCopy(): IReservationRepository;

    public function includeBranch(): IReservationRepository;

    public function includeUser(): IReservationRepository;
}
