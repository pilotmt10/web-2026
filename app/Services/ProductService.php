<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function __construct(private ProductRepository $repository)
    {

    }

    public function findAll(): Collection
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Product
    {
        $product = $this->repository->findById($id);

        if ($product === null) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        return $product;
    }
}
