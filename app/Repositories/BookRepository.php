<?php

namespace App\Repositories;

use App\Interfaces\IBookRepository;
use App\Models\Book;
use App\Utils\Repositories\ResourceRepository;

class BookRepository extends ResourceRepository implements IBookRepository
{
    protected string $modelClass = Book::class;

    public function __construct()
    {
        parent::__construct();
        $this->stringSearchFilters = ["title", "description"];
    }

    public function visible(): IBookRepository
    {
        $this->model = $this->model->visible();
        return $this;
    }
}
