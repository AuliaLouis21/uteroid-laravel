<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Contoh Proyek', 'slug' => 'contoh-proyek'],
            ['name' => 'Klien Kami', 'slug' => 'klien-kami'],
            ['name' => 'Event & Acara', 'slug' => 'event-acara'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
