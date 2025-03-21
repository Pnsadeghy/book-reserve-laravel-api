<?php

namespace App\Repositories;

use App\Interfaces\IBookCopyRepository;
use App\Models\BookCopy;
use App\Utils\Repositories\ResourceRepository;

class BookCopyRepository extends ResourceRepository implements IBookCopyRepository
{
    protected string $modelClass = BookCopy::class;

    public function __construct()
    {
        parent::__construct();
        $this->stringSearchFilters = ['title'];
        $this->requestPropertiesColumns = [
            'visible' => 'is_visible',
            'special' => 'is_special',
        ];
    }

    public function visible(): IBookCopyRepository
    {
        $this->model = $this->model->visible();

        return $this;
    }
}
