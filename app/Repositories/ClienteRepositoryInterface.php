<?php

namespace App\Repositories;

interface ClienteRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
