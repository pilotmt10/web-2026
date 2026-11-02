<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        echo 'Start', PHP_EOL;

        Brand::create([
            'name' => 'Samsung'
        ]);

        Brand::create([
            'name' => 'Xiaomi'
        ]);

        Brand::create([
            'name' => 'LG'
        ]);
    }
}
