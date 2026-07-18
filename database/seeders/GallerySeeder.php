<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Neon Box Restoran Padang',
                'slug' => 'neon-box-restoran-padang',
                'description' => 'Pemasangan neon box 2 sisi untuk Restoran Padang Sederhana di Malang.',
                'category_id' => 1,
            ],
            [
                'title' => 'Papan Nama Toko Elektronik',
                'slug' => 'papan-nama-toko-elektronik',
                'description' => 'Papan nama stainless steel untuk toko elektronik di Surabaya.',
                'category_id' => 1,
            ],
            [
                'title' => 'Branding Kantor PT Sinar Jaya',
                'slug' => 'branding-kantor-pt-sinar-jaya',
                'description' => 'Full branding kantor mulai dari papan nama, banner, hingga interior.',
                'category_id' => 2,
            ],
            [
                'title' => 'Spanduk Event Fashion Week',
                'slug' => 'spanduk-event-fashion-week',
                'description' => 'Cetak spanduk besar untuk event Fashion Week Malang 2026.',
                'category_id' => 3,
            ],
            [
                'title' => 'Stiker Packaging Produk Kopi',
                'slug' => 'stiker-packaging-produk-kopi',
                'description' => 'Desain dan cetak stiker untuk packaging produk kopi lokal.',
                'category_id' => 1,
            ],
            [
                'title' => 'Brosur Promosi Hotel',
                'slug' => 'brosur-promosi-hotel',
                'description' => 'Cetak brosur A4 full colour untuk promosi hotel di Batu.',
                'category_id' => 2,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}
