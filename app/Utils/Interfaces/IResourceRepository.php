<?php

namespace App\Utils\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface IResourceRepository
{
    public function find(Model|string $model, array $columns = ['*']);

    public function all(array $columns = ['*']);

    public function withTrashed();

    public function paginate(
        array $columns = ['*'],
        ?int $perPage = null,
        string $sortBy = 'created_at',
        bool $sortDesc = true,
        string $pageName = 'page',
        ?int $page = null
    );

    public function take(
        int $count,
        string $sortBy = 'created_at',
        bool $sortDesc = true
    );

    public function store(array $data);

    public function update(Model|string $model, array $data);

    public function delete(Model|string $model);

    public function smartDelete(Model|string $model);
}
