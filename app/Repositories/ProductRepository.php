<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findAll(): Collection
    {
        return Product::query()
            ->orderBy('price')
            ->get();
    }

    public function findById(int $id): ?Product
    {
        return Product::query()
            ->with(['category', 'brand'])
            ->where('id', $id)
            ->first();
    }
}
