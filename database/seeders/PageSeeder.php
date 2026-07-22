<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>PT. Utero Kreatif Indonesia</h2>
<p>PT. Utero Kreatif Indonesia atau yang dikenal dengan Utero Group adalah perusahaan yang bergerak di bidang advertising, digital printing, dan creative agency yang berlokasi di Malang, Jawa Timur.</p>
<p>Didirikan sejak tahun 2010, kami telah melayani ratusan klien dari berbagai sektor bisnis mulai dari UMKM hingga korporasi besar.</p>
<h3>Visi</h3>
<p>Menjadi perusahaan advertising dan printing terdepan di Jawa Timur yang memberikan solusi kreatif terbaik untuk pertumbuhan bisnis klien kami.</p>
<h3>Misi</h3>
<ul>
<li>Menyediakan produk advertising dan printing berkualitas tinggi</li>
<li>Memberikan pelayanan terbaik dan tepat waktu</li>
<li>Menghadirkan inovasi desain dan teknologi terkini</li>
<li>Menjalin kerja jangka panjang dengan seluruh mitra bisnis</li>
</ul>',
            ],

        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
