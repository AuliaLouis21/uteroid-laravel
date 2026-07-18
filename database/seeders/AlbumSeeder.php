<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\AlbumPhoto;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'name' => 'Proyek Neon Box Malang',
                'slug' => 'proyek-neon-box-malang',
                'description' => 'Kumpulan hasil pemasangan neon box di berbagai lokasi Malang.',
                'category_id' => 1,
                'photos' => [
                    ['filename' => 'neonbox-1.jpg', 'caption' => 'Neon box toko fashion'],
                    ['filename' => 'neonbox-2.jpg', 'caption' => 'Neon box rumah makan'],
                    ['filename' => 'neonbox-3.jpg', 'caption' => 'Neon box apotek'],
                ],
            ],
            [
                'name' => 'Proyek Papan Nama Surabaya',
                'slug' => 'proyek-papan-nama-surabaya',
                'description' => 'Hasil pemasangan papan nama di Surabaya.',
                'category_id' => 1,
                'photos' => [
                    ['filename' => 'papan nama-1.jpg', 'caption' => 'Papan nama dealer mobil'],
                    ['filename' => 'papan nama-2.jpg', 'caption' => 'Papan nama klinik kecantikan'],
                ],
            ],
        ];

        foreach ($albums as $albumData) {
            $photos = $albumData['photos'];
            unset($albumData['photos']);

            $album = Album::create($albumData);

            foreach ($photos as $photo) {
                $album->photos()->create($photo);
            }
        }
    }
}
