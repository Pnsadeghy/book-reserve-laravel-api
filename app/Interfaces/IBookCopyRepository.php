<?php

namespace App\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IBookCopyRepository extends IResourceRepository
{
    public function visible(): IBookCopyRepository;
}
