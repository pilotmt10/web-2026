<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    public function index(): Collection
    {
        return $this->service->findAll();
    }

    public function show(int $id): Product
    {
        return $this->service->findById($id);
    }
}
