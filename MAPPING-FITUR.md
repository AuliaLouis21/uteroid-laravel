# Mapping Fitur -- Website Utero Group Legacy

> **Project:** Modernisasi Website uterogroup.com
> **Codebase Legacy:** `utero-group-dev/` (backup 02 Juli 2026)
> **Tanggal Mapping:** 16 Juli 2026

---

## 1. Frontend (Public Site)

Akses utama: `http://localhost:8000/` (via `index.php` dengan routing `?t=`)

| No | Fitur | File Controller | File View | Status | Catatan |
|----|-------|----------------|-----------|--------|---------|
| 1 | Homepage | `site/coding/pertamax.php` | `site/views/pertamax/pertamax.php`, `pertamax-slide.php` | Aktif | Landing page + produk promo + slider |
| 2 | Katalog Produk | `site/coding/produk.php` | `site/views/produk/produk.php`, `produk.detil.php`, `produk.cat.php` | Aktif | Listing + detail + pagination + filter kategori |
| 3 | Produk per Kategori | `site/coding/cat.php` | `site/views/produk/produk.cat.php` | Aktif | Filter produk berdasarkan kategori |
| 4 | Berita/News | `site/coding/news.php` | `site/views/news/news.php`, `news.detil.php` | Aktif | Listing + detail berita dari CMS |
| 5 | Galeri Foto | `site/coding/gallery.php` | `site/views/gallery/gallery.php` | Aktif | Galeri gabungan (foto, video, audio) |
| 6 | Galeri Foto Detail | `site/coding/picture.php` | `site/views/picture/picture.php`, `picture.detil.php` | Aktif | Album foto + detail gambar |
| 7 | Galeri Video | `site/coding/video.php` | `site/views/video/video.php`, `video.detil.php` | Aktif | Daftar video + player (YouTube embed) |
| 8 | Galeri Audio | `site/coding/audio.php` | `site/views/audio/audio.php` | Aktif | Player audio streaming |
| 9 | Testimonial | `site/coding/testimonial.php` | `site/views/testimonial/testimonial.php` | Aktif | Form submit + approval system |
| 10 | Order/Pemesanan | `site/coding/order.php` | `site/views/order/order.php`, `order.f.php` | Aktif | Multi-step form pemesanan |
| 11 | Kontak | `site/coding/contact.php` | `site/views/contact/contact.php` | Aktif | Form kontak + Google Maps + Yahoo Messenger (usang) |
| 12 | Halaman Statis | `site/coding/pages.php` | `site/views/pages/pages.php` | Aktif | About, dll dari database |
| 13 | Download | `site/coding/download.php` | `site/views/download/download.php` | Aktif | Halaman unduhan file |
| 14 | Iklan/Ads | `site/coding/ads.php` | `site/views/kanan.php` (sidebar) | Aktif | Banner promosi di sidebar kanan |
| 15 | Registrasi Member | `site/coding/signup.php` | `site/views/signup/` | Aktif | Form pendaftaran member |
| 16 | Sidebar Kiri | -- | `site/views/kiri.php` | Aktif | Navigasi kategori produk |
| 17 | Sidebar Kanan | -- | `site/views/kanan.php` | Aktif | Produk unggulan + iklan |

### Frontend Helpers

| File | Fungsi |
|------|--------|
| `site/config.php` | Koneksi database (mysqli) + variabel global |
| `site/func/func.php` | Fungsi utilitas (escape, sanitasi, parsing gambar) |
| `site/func/menu.php` | Fungsi navigasi aktif + koneksi DB hardcoded |
| `site/func/tanggal.php` | Format tanggal Indonesia |
| `site/func/captcha.php` | Captcha generator |
| `site/func/hits.php` | Hit counter |
| `site/func/ambildata.php` | Fetch data helper |
| `site/func/class.phpmailer.php` | PHPMailer (versi lama) |
| `site/func/com_terbilang.php` | Konversi angka ke terbilang |

---

## 2. CMS Admin (Content Management System)

Akses: `http://localhost:8000/cms/` (routing via `?cms=`)

| No | Fitur | File Controller | File View | Status | Catatan |
|----|-------|----------------|-----------|--------|---------|
| 1 | Login/Logout | `cms/login/loginact.php` | `cms/views/login/` | Aktif | Plaintext password comparison |
| 2 | Dashboard | `cms/index.php` | `cms/views/dashboard/` | Aktif | Overview admin |
| 3 | Kelola Posts/Berita | `cms/coding/posts.php` | `cms/views/posts/posts.c.php`, `posts.l.php` | Aktif | CRUD berita/artikel |
| 4 | Kelola Pages | `cms/coding/pages.php` | `cms/views/pages/pages.c.php`, `pages.l.php` | Aktif | CRUD halaman statis |
| 5 | Kelola Produk | `cms/coding/catalog.php` | `cms/views/catalog/catalog.c.php`, `catalog.l.php` | Aktif | CRUD produk + upload gambar |
| 6 | Kelola Kategori Produk | `cms/coding/catalog.php` | `cms/views/catalog/` | Aktif | Sub-fungsi dari produk |
| 7 | Kelola Gallery | `cms/coding/gallery.php` | `cms/views/gallery/` | Aktif | CRUD galeri foto |
| 8 | Kelola Video | `cms/coding/video.php` | `cms/views/video/` | Aktif | CRUD galeri video |
| 9 | Kelola Audio | `cms/coding/audio.php` | `cms/views/audio/` | Aktif | CRUD galeri audio |
| 10 | Kelola Testimonial | `cms/coding/testimonial.php` | `cms/views/testimonial/` | Aktif | Approve/reject testimonial |
| 11 | Kelola Order | `cms/coding/order.php` | `cms/views/order/order.l.php`, `order.d.php`, `order.v.php` | Aktif | Lihat + hapus order customer |
| 12 | Kelola Iklan/Ads | `cms/coding/ads.php` | `cms/views/ads/` | Aktif | CRUD banner iklan |
| 13 | Kelola Setting | `cms/coding/setting.php` | `cms/views/setting/setting.set.php`, `setting.pass.php` | Aktif | Pengaturan site + ganti password |
| 14 | Upload Gambar | `cms/coding/upload.php` | -- | Aktif | Upload handler |

### CMS Helpers

| File | Fungsi |
|------|--------|
| `cms/config.php` | Koneksi database (mysql_* legacy) |
| `cms/func/func.php` | Fungsi utilitas CMS (escape rusak) |

---

## 3. Admin Panel (CodeIgniter 1.x)

Akses: `http://localhost:8000/admin/`

| No | Fitur | File | Status | Catatan |
|----|-------|------|--------|---------|
| 1 | Admin Dashboard | `admin/system/application/controllers/` | Aktif | CI 1.x admin panel |
| 2 | Nota Record | `admin/system/application/controllers/notarecord.php` | Aktif | Manajemen nota/catatan |
| 3 | Database Admin | `admin/system/application/` | Aktif | CRUD via Active Record CI |

### Catatan Admin Panel
- Menggunakan **CodeIgniter 1.x** (sangat lawas, EOL)
- Menggunakan Active Record pattern (lebih aman dari CMS manual)
- Masih ada raw query di beberapa controller (terutama `notarecord.php`)

---

## 4. Modul Tambahan

| No | Modul | File | Status | Catatan |
|----|-------|------|--------|---------|
| 1 | Gramfox | `gramfox/` | Aktif | Modul migrasi + upload (TIDAK AMAN) |
| 2 | SIM | `sim/` | Aktif | Sistem Informasi (termasuk adminer.php) |
| 3 | XData | `xdata/` | Aktif | Data berita & artikel (gambar) |

### Catatan Modul Tambahan
- `gramfox/upload.php` -- File upload tanpa autentikasi (CRITICAL)
- `gramfox/migrate.php` -- SQL migration tanpa autentikasi (CRITICAL)
- `sim/` -- Termasuk `adminer.php` (database admin tool, harus dihapus)

---

## 5. Aset & Media

| Direktori | Fungsi | Isi |
|-----------|--------|-----|
| `gambar/` | Gambar produk | 1000+ file |
| `gallery/` | Gambar galeri | Foto-foto galeri |
| `iklan/` | Asset iklan | Banner promosi |
| `imgupload/` | Upload gambar | Dari user dan CMS |
| `xdata/` | Data berita | Gambar artikel |
| `audio/` | File audio | Streaming audio |

---

## 6. Routing Summary

Routing pada legacy menggunakan parameter GET:

| URL Pattern | Routing | Target |
|-------------|---------|--------|
| `/?t=` | `index.php` | Frontend pages |
| `/?cms=` | `cms/index.php` | CMS admin |
| `/admin/` | `admin/index.php` | CI Admin Panel |
| `/?t=produk&slug=` | `site/coding/produk.php` | Detail produk |
| `/?t=news&slug=` | `site/coding/news.php` | Detail berita |
| `/?t=gallery` | `site/coding/gallery.php` | Galeri utama |
| `/?t=testimonial` | `site/coding/testimonial.php` | Testimonial |
| `/?t=order` | `site/coding/order.php` | Form order |
| `/?t=contact` | `site/coding/contact.php` | Kontak |
| `/?t=pages&slug=` | `site/coding/pages.php` | Halaman statis |
| `/?t=download` | `site/coding/download.php` | Download |

---

## 7. Mapping ke Laravel (Rencana Migrasi)

### Frontend Routes (Laravel)

| Legacy URL | Laravel Route | Controller | Method |
|-----------|---------------|------------|--------|
| `/?t=` (homepage) | `GET /` | `HomeController` | `index` |
| `/?t=produk` | `GET /produk` | `ProductController` | `index` |
| `/?t=produk&slug=X` | `GET /produk/{slug}` | `ProductController` | `show` |
| `/?t=produk&cat=X` | `GET /produk/kategori/{slug}` | `ProductController` | `category` |
| `/?t=news` | `GET /berita` | `PostController` | `index` |
| `/?t=news&slug=X` | `GET /berita/{slug}` | `PostController` | `show` |
| `/?t=gallery` | `GET /galeri` | `GalleryController` | `index` |
| `/?t=gallery&type=foto` | `GET /galeri/foto/{slug}` | `GalleryController` | `photos` |
| `/?t=gallery&type=video` | `GET /galeri/video/{slug}` | `GalleryController` | `videos` |
| `/?t=testimonial` | `GET /testimonial` | `TestimonialController` | `index` |
| `POST testimonial` | `POST /testimonial` | `TestimonialController` | `store` |
| `/?t=order` | `GET /order` | `OrderController` | `create` |
| `POST order` | `POST /order` | `OrderController` | `store` |
| `/?t=contact` | `GET /kontak` | `ContactController` | `index` |
| `POST contact` | `POST /kontak` | `ContactController` | `send` |
| `/?t=pages&slug=X` | `GET /halaman/{slug}` | `PageController` | `show` |
| `/?t=download` | `GET /download` | `DownloadController` | `index` |

### Admin Routes (Laravel)

| Legacy URL | Laravel Route | Controller | Method |
|-----------|---------------|------------|--------|
| `/?cms=` (dashboard) | `GET /admin` | `Admin\DashboardController` | `index` |
| `/?cms=posts` | `GET /admin/posts` | `Admin\NewsController` | `index` |
| `/?cms=catalog` | `GET /admin/products` | `Admin\ProductController` | `index` |
| `/?cms=pages` | `GET /admin/pages` | `Admin\PageController` | `index` |
| `/?cms=gallery` | `GET /admin/galleries` | `Admin\GalleryController` | `index` |
| `/?cms=testimonial` | `GET /admin/testimonials` | `Admin\TestimonialController` | `index` |
| `/?cms=order` | `GET /admin/orders` | `Admin\OrderController` | `index` |
| `/?cms=ads` | `GET /admin/advertisements` | `Admin\AdvertisementController` | `index` |
| `/?cms=setting` | `GET /admin/settings` | `Admin\SettingController` | `edit` |

---

> **Catatan:** Document ini dibuat berdasarkan pembacaan menyeluruh seluruh file PHP di codebase legacy.

*Dokumen ini dibuat: 16 Juli 2026*
