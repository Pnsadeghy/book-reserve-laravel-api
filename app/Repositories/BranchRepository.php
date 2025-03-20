<?php

namespace App\Repositories;

use App\Interfaces\IBranchRepository;
use App\Models\Branch;
use App\Utils\Repositories\ResourceRepository;

class BranchRepository extends ResourceRepository implements IBranchRepository
{
    protected string $modelClass = Branch::class;

    public function __construct()
    {
        parent::__construct();
        $this->stringSearchFilters = ['title', 'address'];
        $this->requestPropertiesColumns = [
            'visible' => 'is_visible',
        ];
    }

    public function visible(): IBranchRepository
    {
        $this->model = $this->model->visible();

        return $this;
    }
}
