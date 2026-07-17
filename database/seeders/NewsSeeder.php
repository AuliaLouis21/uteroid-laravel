<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Utero Indonesia Buka Kunjungan Industri untuk SMK',
                'slug' => 'utero-indonesia-buka-kunjungan-industri-untuk-smk',
                'excerpt' => 'Utero Indonesia membuka kesempatan kunjungan industri untuk siswa SMK se-Jawa Timur.',
                'content' => 'Utero Indonesia yang berlokasi di Jalan Bantaran 1 No. 25, Malang membuka kesempatan untuk siswa SMK melakukan kunjungan industri. Dalam kunjungan ini, siswa akan mendapatkan insight mengenai branding, desain, audio visual, dan ilmu lainnya.',
                'image' => null,
                'published_at' => now(),
            ],
            [
                'title' => 'Tips Branding di Tahun 2026',
                'slug' => 'tips-branding-di-tahun-2026',
                'excerpt' => 'Strategi branding terbaru yang efektif untuk bisnis di era digital.',
                'content' => 'Di era digital saat ini, branding menjadi salah satu kunci keberhasilan sebuah bisnis. Berikut tips branding yang bisa Anda terapkan untuk meningkatkan brand awareness dan meningkatkan penjualan.',
                'image' => null,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Pentingnya Desain Visual dalam Marketing',
                'slug' => 'pentingnya-desain-visual-dalam-marketing',
                'excerpt' => 'Desain visual memainkan peran penting dalam strategi marketing modern.',
                'content' => 'Desain visual bukan sekadar soal estetika, tapi juga tentang komunikasi yang efektif dengan target pasar Anda. Dalam artikel ini, kita akan membahas mengapa desain visual sangat penting dalam marketing.',
                'image' => null,
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($articles as $article) {
            News::create($article);
        }
    }
}
