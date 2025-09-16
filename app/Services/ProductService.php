<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

class ProductService
{
    private ProductRepositoryInterface $repo;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repo->paginate($filters, $perPage);
    }

    public function show(int $id): ?Product
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Product
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data): Product
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}