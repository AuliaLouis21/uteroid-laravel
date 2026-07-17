# Utero Group — Company Website

> **PT. Utero Kreatif Indonesia** — Advertising, Digital Printing & Creative Agency berbasis di Malang, Jawa Timur.

Website company profile yang menampilkan produk, galeri, berita, testimonial, dan sistem pemesanan online untuk layanan periklanan dan percetakan.

---

## Informasi Umum

| Item | Detail |
|------|--------|
| **Domain** | uterogroup.com |
| **Jenis** | Company Profile + CMS |
| **PHP Version (Legacy)** | PHP 5.1 (konfigurasi awal), .htaccess mengarah ke ea-php73 |
| **Database** | MySQL / MariaDB — database uteroid_cms |
| **Hosting** | Shared Hosting (cPanel) |
| **Backup Tanggal** | 02 Juli 2026 |

---

## Struktur Direktori

```
/
├── index.php              # Front controller utama (routing via ?t=)
├── .htaccess              # Handler PHP cPanel
├── php.ini                # Konfigurasi PHP (memory 512M, upload 512M)
├── .gitignore
│
├── site/                  # === FRONTEND (Public Site) ===
│   ├── config.php         # Koneksi DB (mysqli) + variabel global
│   ├── coding/            # Controller / logic tiap halaman
│   │   ├── pertamax.php   # Homepage
│   │   ├── produk.php     # Katalog produk + detail + pagination
│   │   ├── news.php       # Berita / artikel
│   │   ├── gallery.php    # Galeri gambar
│   │   ├── contact.php    # Halaman kontak
│   │   ├── order.php      # Form pemesanan
│   │   ├── testimonial.php
│   │   ├── video.php      # Galeri video
│   │   ├── audio.php      # Galeri audio
│   │   ├── download.php   # Halaman unduhan
│   │   ├── pages.php      # Halaman statis (about, dsb.)
│   │   ├── ads.php        # Halaman iklan / promosi
│   │   └── signup.php     # Registrasi member
│   ├── views/             # Template / tampilan (header, footer, per-modul)
│   │   ├── header.php     # Head HTML, meta tags, navbar, GA, FB Pixel
│   │   ├── footer.php     # Footer, Google Maps embed, WA floating btn
│   │   ├── kiri.php       # Sidebar kiri
│   │   ├── kanan.php      # Sidebar kanan
│   │   ├── style.css      # Stylesheet utama
│   │   └── <modul>/       # Sub-folder view per fitur
│   ├── func/              # Helper & library
│   │   ├── func.php       # Fungsi utilitas (image parsing, validasi, sanitasi)
│   │   ├── menu.php       # Fungsi navigasi aktif
│   │   ├── tanggal.php    # Format tanggal Indonesia
│   │   ├── captcha.php    # Captcha generator
│   │   ├── class.phpmailer.php  # PHPMailer (versi lama)
│   │   └── hits.php       # Hit counter
│   ├── js/                # JavaScript frontend
│   ├── images/            # Asset gambar site
│   └── mod/               # Modul tambahan
│
├── cms/                   # === CMS (Content Management System) ===
│   ├── config.php         # Koneksi DB (mysql_* legacy)
│   ├── index.php          # Front controller CMS (routing via ?cms=)
│   ├── login/             # Halaman login & logout admin
│   ├── coding/            # Controller CMS (posts, catalog, order, dsb.)
│   ├── views/             # Template CMS (CRUD views)
│   ├── func/              # Helper CMS
│   ├── css/               # Stylesheet admin
│   ├── js/                # JavaScript admin
│   └── images/            # Asset admin
│
├── admin/                 # === ADMIN PANEL (CodeIgniter 1.x) ===
│   ├── index.php          # CI front controller
│   ├── system/            # CodeIgniter 1.x core
│   │   ├── application/   # App (controllers, models, views)
│   │   ├── codeigniter/   # CI core engine
│   │   ├── database/      # DB drivers
│   │   └── libraries/     # CI libraries
│   ├── lib/               # Library tambahan (FPDF, image resize)
│   └── resources/         # Asset admin (jQuery UI, SimpleModal, CSS)
│
├── sql/                   # === DATABASE ===
│   └── uteroid_cms.sql    # Full SQL dump (MariaDB 11.4)
│
├── gambar/                # Gambar produk (1000+ file)
├── gallery/               # Gambar galeri
├── iklan/                 # Asset iklan
├── imgupload/             # Upload gambar user / CMS
├── xdata/                 # Data berita & artikel (gambar)
├── audio/                 # File audio
├── sim/                   # Modul SIM (Sistem Informasi)
├── gramfox/               # Modul Gramfox
└── .well-known/           # Domain verification
```

---

## Database Schema

Database uteroid_cms menggunakan engine **MyISAM** dengan 21 tabel:

| Tabel | Deskripsi |
|-------|-----------|
| dmin | User admin (plain-text password!) |
| ds | Konten iklan / promosi |
| lbumpic | Album foto |
| udgal | Galeri audio |
| category | Kategori umum |
| catproduk | Kategori produk |
| dataupload | Data file upload |
| image | Gambar produk |
| jnsproduk | Jenis produk |
| logmin | Log admin |
| logminfo | Log info admin |
| member | Data member / pelanggan |
| ordernya | Detail order |
| orderuser | Data user order |
| page | Halaman statis (about, dsb.) |
| pictgal | Galeri gambar |
| posts | Berita / artikel |
| produk | Data produk |
| setting | Pengaturan website |
| 	esti | Testimonial |
| idgal | Galeri video |

---

## Teknologi Yang Digunakan

- **Backend:** PHP 5.1 (legacy) — sebagian sudah menggunakan mysqli_*, sebagian masih mysql_*
- **Framework Admin:** CodeIgniter 1.x (sangat lawas, EOL)
- **Database:** MySQL / MariaDB (MyISAM)
- **Frontend:** HTML4/XHTML Strict, CSS2, JavaScript vanilla, jQuery, jQuery UI
- **Library:** PHPMailer (versi lama), FPDF (PDF generator), SimpleModal
- **Analytics:** Google Analytics (UA), Facebook Pixel
- **Hosting:** cPanel Shared Hosting

---

## Cara Menjalankan (Development)

### Prasyarat
- PHP 7.4+ atau 8.x (target upgrade)
- MySQL 5.7+ / MariaDB 10.x+
- Apache dengan mod_rewrite (atau XAMPP/Laragon)

### Langkah Setup
1. **Import database:**
   ```bash
   mysql -u root -p -e "CREATE DATABASE uteroid_cms"
   mysql -u root -p uteroid_cms < sql/uteroid_cms.sql
   ```
2. **Konfigurasi koneksi:** Edit file berikut sesuai environment lokal:
   - site/config.php — koneksi frontend
   - cms/config.php — koneksi CMS
   - site/func/menu.php — koneksi menu (hardcoded)
3. **Jalankan web server:**
   ```bash
   php -S localhost:8000
   ```
4. **Akses:**
   - Frontend: http://localhost:8000/
   - CMS: http://localhost:8000/cms/

---

## Masalah Keamanan Yang Diketahui

> ⚠️ **PENTING:** Codebase ini memiliki banyak masalah keamanan yang HARUS diperbaiki sebelum production.

1. **SQL Injection** — Banyak query yang langsung memasukkan input user tanpa prepared statements
2. **Plain-text Password** — Tabel dmin menyimpan password tanpa hashing
3. **Kredensial Hardcoded** — Username & password DB tersebar di banyak file
4. **Fungsi Deprecated** — Penggunaan mysql_* functions (dihapus sejak PHP 7.0)
5. **XSS** — Output tidak di-escape dengan htmlspecialchars()
6. **CSRF** — Tidak ada token CSRF pada form
7. **Session Management** — session_start() dipanggil setelah output
8. **Error Display** — display_errors = On di production

---

## Status Project

🔴 **Legacy — Perlu Modernisasi Total**

Project ini akan diupgrade dan dikembangkan ulang. Lihat file TUGAS-MAGANG.md untuk detail rencana pengembangan.

---

## Kontak

**PT. Utero Kreatif Indonesia** (Rumah Merah OXYZ)
Jalan Bantaran 1 No. 25, Tulusrejo, Kec. Lowokwaru
Malang, Jawa Timur 65141

- **Telp:** 0341 408408
- **WhatsApp:** 081 999 900 900
- **Email:** marketingutero@gmail.com
- **Website:** [uterogroup.com](http://uterogroup.com)
