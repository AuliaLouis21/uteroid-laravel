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
            [
                'title' => 'Syarat & Ketentuan',
                'slug' => 'syarat-ketentuan',
                'content' => '<h2>Syarat & Ketentuan</h2>
<h3>1. Pemesanan</h3>
<p>Semua pemesanan produk dan layanan harus dilakukan melalui form pemesanan yang tersedia di website atau menghubungi tim marketing kami secara langsung.</p>
<h3>2. Pembayaran</h3>
<p>Pembayaran dilakukan dengan sistem DP minimal 50% dari total biaya. Pelunasan dilakukan setelah produk selesai dan siap dikirim.</p>
<h3>3. Waktu Pengerjaan</h3>
<p>Waktu pengerjaan bervariasi tergantung jenis produk dan jumlah. Estimasi waktu akan dikonfirmasi saat pemesanan.</p>
<h3>4. Garansi</h3>
<p>Kami memberikan garansi perbaikan untuk produk yang mengalami cacat produksi dalam waktu 7 hari setelah produk diterima.</p>',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
