<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Neon Box', 'slug' => 'neon-box'],
            ['name' => 'Papan Nama', 'slug' => 'papan-nama'],
            ['name' => 'Brosur', 'slug' => 'brosur'],
            ['name' => 'Spanduk', 'slug' => 'spanduk'],
            ['name' => 'Stiker', 'slug' => 'stiker'],
            ['name' => 'Kartu Nama', 'slug' => 'kartu-nama'],
            ['name' => 'Packaging', 'slug' => 'packaging'],
            ['name' => 'Desain', 'slug' => 'desain'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
