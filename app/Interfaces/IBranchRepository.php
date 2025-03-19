<?php

namespace App\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IBranchRepository extends IResourceRepository
{
    public function visible(): IBranchRepository;
}
