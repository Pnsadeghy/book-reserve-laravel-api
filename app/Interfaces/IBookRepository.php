<?php

namespace App\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IBookRepository extends IResourceRepository {
    public function visible(): IBookRepository;
}
