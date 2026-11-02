<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i < 10; $i++) {
            Product::create([
                'name' => 'Товар ' . $i,
                'price' => $i * 15,
                'old_price' => $i * 25,
                'category_id' => 1,
                'brand_id' => 1
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            Product::create([
                'name' => 'Товар ' . $i,
                'price' => $i * 15,
                'old_price' => $i * 25,
                'category_id' => 2,
                'brand_id' => 2
            ]);
        }
    }
}
