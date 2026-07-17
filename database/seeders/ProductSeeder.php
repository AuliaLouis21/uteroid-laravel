<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Neon Box 1 Sisi',
                'slug' => 'neon-box-1-sisi',
                'size' => '120cm x 80cm',
                'thickness' => '10cm',
                'min_order' => 1,
                'unit_price' => 1500000,
                'description' => 'Neon box 1 sisi dengan rangka besi holo, print digital, lampu TL. Cocok untuk papan nama toko dan bisnis Anda.',
                'product_category_id' => 1,
                'is_promo' => false,
                'published_at' => now(),
            ],
            [
                'name' => 'Neon Box 2 Sisi',
                'slug' => 'neon-box-2-sisi',
                'size' => '120cm x 80cm',
                'thickness' => '12cm',
                'min_order' => 1,
                'unit_price' => 2500000,
                'description' => 'Neon box 2 sisi visual, rangka holo dan visual stiker cutting / vinil. Bisa dilihat dari 2 arah.',
                'product_category_id' => 1,
                'is_promo' => true,
                'published_at' => now(),
            ],
            [
                'name' => 'Papan Nama 1 Sisi',
                'slug' => 'papan-nama-1-sisi',
                'size' => '150cm x 50cm',
                'thickness' => '-',
                'min_order' => 1,
                'unit_price' => 800000,
                'description' => 'Papan nama 1 sisi dengan besi holo, plat penahan angin, vinil / print frontlite.',
                'product_category_id' => 2,
                'is_promo' => false,
                'published_at' => now(),
            ],
            [
                'name' => 'Brosur Full Colour',
                'slug' => 'brosur-full-colour',
                'size' => 'A4',
                'thickness' => 'kertas art paper',
                'min_order' => 100,
                'unit_price' => 2500,
                'description' => 'Brosur full colour, kertas art paper, cocok untuk promosi produk dan layanan bisnis Anda.',
                'product_category_id' => 3,
                'is_promo' => false,
                'published_at' => now(),
            ],
            [
                'name' => 'Kartu Nama',
                'slug' => 'kartu-nama',
                'size' => '9cm x 5.5cm',
                'thickness' => 'art paper 260gr',
                'min_order' => 100,
                'unit_price' => 1500,
                'description' => 'Kartu nama kertas art paper 260 gr, full colour, bolak balik, laminasi doff.',
                'product_category_id' => 6,
                'is_promo' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
