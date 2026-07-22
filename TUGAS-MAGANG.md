# 📋 TUGAS MAGANG — Modernisasi Website Utero Group

> **Project:** Upgrade & Modernisasi website uterogroup.com
> **Tujuan:** Migrasi dari PHP 5.1 (legacy) ke PHP 8.x dengan arsitektur modern
> **Backup Referensi:** ackup-02072026/

---

## 🎯 Tujuan Utama

1. Memperbaiki semua masalah keamanan yang ada
2. Migrasi kode PHP dari versi 5.1 ke PHP 8.x
3. Mengganti arsitektur legacy dengan framework modern (Laravel)
4. Memperbaiki tampilan frontend dengan framework CSS modern
5. Membuat CMS admin yang lebih baik dan aman

---

## 📌 Fase 1: Analisis & Dokumentasi (Minggu 1-2)

### Tugas 1.1 — Pelajari Codebase Legacy
- [ ] Clone repository dan setup environment lokal (XAMPP/Laragon)
- [ ] Import database dari sql/uteroid_cms.sql
- [ ] Jalankan website legacy di lokal dan pahami alur kerja
- [ ] Buat catatan tentang setiap halaman dan fungsinya
- [ ] Identifikasi semua fitur yang ada saat ini

### Tugas 1.2 — Mapping Fitur
Dokumentasikan semua fitur yang ada dalam format tabel:

| No | Fitur | File Terkait | Status | Catatan |
|----|-------|-------------|--------|---------|
| 1 | Homepage | site/coding/pertamax.php | Aktif | Landing page + produk promo |
| 2 | Katalog Produk | site/coding/produk.php | Aktif | Listing + detail + pagination |
| 3 | Berita/News | site/coding/news.php | Aktif | CRUD dari CMS |
| 4 | Gallery | site/coding/gallery.php | Aktif | Foto, Video, Audio |
| 5 | Testimonial | site/coding/testimonial.php | Aktif | Approval system |
| 6 | Order | site/coding/order.php | Aktif | Form pemesanan |
| 7 | Contact | site/coding/contact.php | Aktif | Form kontak |
| 8 | Halaman Statis | site/coding/pages.php | Aktif | About, dll dari DB |
| 9 | Download | site/coding/download.php | Aktif | File download |
| 10 | Iklan/Ads | site/coding/ads.php | Aktif | Konten promosi |
| 11 | CMS Admin | cms/index.php | Aktif | Panel kelola konten |
| 12 | Admin Panel | dmin/index.php | Aktif | CodeIgniter 1.x |

### Tugas 1.3 — Audit Keamanan
Buat laporan audit keamanan yang mencakup:
- [ ] Temukan semua query SQL yang rentan injection (cari $_GET, $_POST yang langsung masuk query)
- [ ] Identifikasi semua penggunaan mysql_* functions (deprecated)
- [ ] Cek apakah ada password yang disimpan plain-text
- [ ] Cari kredensial yang hardcoded di source code
- [ ] Periksa semua form apakah ada proteksi CSRF
- [ ] Cek apakah output di-escape untuk mencegah XSS

**Deliverable:** Dokumen AUDIT-KEAMANAN.md

---

## 📌 Fase 2: Setup Project Baru (Minggu 3-4)

### Tugas 2.1 — Inisialisasi Project Laravel
- [ ] Install Laravel 11.x (atau versi terbaru stabil)
- [ ] Setup konfigurasi .env (database, app name, dll)
- [ ] Konfigurasi database connection ke MySQL/MariaDB
- [ ] Setup Git repository baru dengan branching strategy (main, develop, feature/*)

### Tugas 2.2 — Migrasi Database
Buat migration Laravel untuk semua tabel. Sesuaikan dengan standar Laravel:

`php
// Contoh: Tabel admin lama
// CREATE TABLE admin (user varchar(12), pass varchar(12), email varchar(30))

// Migration baru:
Schema::create('users', function (Blueprint ) {
    ->id();
    ->string('name');
    ->string('email')->unique();
    ->string('password'); // Hashed dengan bcrypt!
    ->enum('role', ['admin', 'editor', 'viewer'])->default('viewer');
    ->rememberToken();
    ->timestamps();
});
`

Tabel yang harus di-migrate (dengan perbaikan):

| Tabel Lama | Tabel Baru (Laravel) | Perubahan |
|-----------|---------------------|-----------|
| dmin | users | Tambah hashing password, role system, timestamps |
| posts | posts | Tambah user_id (FK), slug unique, soft deletes |
| catproduk | product_categories | Naming convention, timestamps, slug |
| produk | products | FK ke categories, proper relations |
| image | product_images | FK ke products, polymorphic option |
| jnsproduk | product_types | Naming convention |
| page | pages | Slug unique, soft deletes |
| ds | dvertisements | Timestamps, FK user |
| lbumpic | lbums | Timestamps |
| pictgal | lbum_photos | FK ke albums |
| idgal | lbum_videos | FK ke albums |
| udgal | lbum_audios | FK ke albums |
| 	esti | 	estimonials | Status enum, timestamps |
| ordernya | orders | Relasi proper, status tracking |
| orderuser | order_items | FK ke orders |
| member | Merge ke users | Role 'member' |
| category | categories | Timestamps |
| setting | settings | Key-value pair |
| dataupload | uploads | Polymorphic, disk storage |

- [ ] Buat semua file migration
- [ ] Buat semua file seeder dari data lama
- [x] Buat script import data dari SQL dump lama (`import:legacy` command)
- [ ] Test migration: php artisan migrate:fresh --seed

### Tugas 2.3 — Setup Authentication
- [ ] Install Laravel Breeze atau Fortify
- [ ] Konfigurasi authentication (login, register, forgot password)
- [ ] Buat middleware role-based access (admin, editor, viewer)
- [ ] Implementasi password hashing (bcrypt)

---

## 📌 Fase 3: Backend Development (Minggu 5-8)

### Tugas 3.1 — Buat Model & Relationships
Buat Eloquent Model untuk setiap tabel dengan relasi yang benar:

`
User -> hasMany -> Post
User -> hasMany -> Order
ProductCategory -> hasMany -> Product
Product -> hasMany -> ProductImage
Product -> belongsTo -> ProductCategory
Album -> hasMany -> AlbumPhoto / AlbumVideo / AlbumAudio
Order -> hasMany -> OrderItem
Order -> belongsTo -> User
`

- [ ] Buat semua Model dengan $fillable, $casts, dan relasi
- [ ] Tambahkan accessor & mutator yang diperlukan
- [ ] Buat Form Request validation untuk setiap resource

### Tugas 3.2 — Buat Controller & Routes (Frontend)
Migrasi setiap halaman frontend menjadi controller Laravel:

| Route | Controller | Method | Keterangan |
|-------|-----------|--------|------------|
| GET / | HomeController | index | Homepage + produk promo |
| GET /produk | ProductController | index | Listing produk + pagination |
| GET /produk/{slug} | ProductController | show | Detail produk |
| GET /produk/kategori/{slug} | ProductController | category | Produk per kategori |
| GET /berita | PostController | index | Listing berita |
| GET /berita/{slug} | PostController | show | Detail berita |
| GET /galeri | GalleryController | index | Galeri utama |
| GET /galeri/foto/{slug} | GalleryController | photos | Album foto |
| GET /galeri/video/{slug} | GalleryController | ideos | Album video |
| GET /testimonial | TestimonialController | index | Testimonial |
| POST /testimonial | TestimonialController | store | Submit testimonial |
| GET /kontak | ContactController | index | Halaman kontak |
| POST /kontak | ContactController | send | Kirim pesan kontak |
| GET /order | OrderController | create | Form order |
| POST /order | OrderController | store | Submit order |
| GET /halaman/{slug} | PageController | show | Halaman statis |
| GET /download | DownloadController | index | Halaman unduhan |

- [ ] Buat semua controller dengan logic yang sesuai
- [ ] Implementasikan pagination yang benar (built-in Laravel)
- [ ] Tambahkan validasi input pada semua form
- [ ] Pastikan semua query menggunakan Eloquent / Query Builder (BUKAN raw query)

### Tugas 3.3 — Buat Controller & Routes (Admin CMS)
Buat admin panel menggunakan route group dengan middleware auth:

`php
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('posts', Admin\PostController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('pages', Admin\PageController::class);
    Route::resource('galleries', Admin\GalleryController::class);
    Route::resource('testimonials', Admin\TestimonialController::class);
    Route::resource('orders', Admin\OrderController::class);
    Route::resource('advertisements', Admin\AdvertisementController::class);
    Route::resource('uploads', Admin\UploadController::class);
    Route::get('settings', [Admin\SettingController::class, 'edit']);
    Route::put('settings', [Admin\SettingController::class, 'update']);
});
`

- [ ] Buat semua admin controller dengan full CRUD
- [ ] Implementasi upload gambar dengan Laravel Storage
- [ ] Buat dashboard dengan statistik (jumlah produk, order, visitor, dll)
- [ ] Tambahkan fitur pencarian & filter di setiap listing

---

## 📌 Fase 4: Frontend Development (Minggu 9-11)

### Tugas 4.1 — Setup Frontend Stack
- [ ] Install Tailwind CSS (atau Bootstrap 5)
- [ ] Setup Vite untuk asset compilation
- [ ] Buat layout dasar (header, footer, sidebar)
- [ ] Implementasi responsive design (mobile-first)

### Tugas 4.2 — Buat Blade Templates (Frontend)
Migrasi semua view dari PHP mentah ke Blade template:

`
resources/views/
├── layouts/
│   ├── app.blade.php          # Layout utama
│   ├── header.blade.php       # Navigasi
│   └── footer.blade.php       # Footer + kontak
├── home/
│   └── index.blade.php        # Homepage
├── products/
│   ├── index.blade.php        # Listing produk
│   ├── show.blade.php         # Detail produk
│   └── category.blade.php    # Per kategori
├── posts/
│   ├── index.blade.php        # Listing berita
│   └── show.blade.php         # Detail berita
├── gallery/
│   ├── index.blade.php
│   ├── photos.blade.php
│   └── videos.blade.php
├── testimonials/
│   └── index.blade.php
├── contact/
│   └── index.blade.php
├── orders/
│   └── create.blade.php
└── pages/
    └── show.blade.php
`

- [ ] Buat semua Blade template sesuai desain
- [ ] Pindahkan semua inline CSS ke file terpisah
- [ ] Pastikan semua output di-escape ({{ }} bukan {!! !!} kecuali memang butuh HTML)
- [ ] Implementasi komponen Blade yang reusable (cards, pagination, breadcrumb)

### Tugas 4.3 — Buat Blade Templates (Admin)
- [ ] Buat layout admin (sidebar navigation, top bar)
- [ ] Buat CRUD views untuk semua resource admin
- [x] Implementasi rich text editor (TinyMCE/CKEditor) untuk posts & pages
- [x] Buat komponen upload gambar dengan preview
- [ ] Implementasi DataTables atau Livewire untuk listing data

---

## 📌 Fase 5: Fitur Tambahan & Optimasi (Minggu 12-14)

### Tugas 5.1 — SEO & Performance
- [x] Implementasi meta tags dinamis (title, description, keywords)
- [x] Setup Open Graph tags untuk social media sharing
- [x] Implementasi sitemap.xml otomatis
- [x] Setup image optimization (lazy loading, WebP conversion)
- [x] Implementasi caching (page cache, query cache)

### Tugas 5.2 — Integrasi   
- [x] Setup mailer (SMTP) untuk form kontak & notifikasi order
- [x] Integrasi WhatsApp API untuk notifikasi
- [x] Setup Google Analytics 4 (ganti dari UA yang sudah deprecated)
- [x] Implementasi reCAPTCHA pada form publik

### Tugas 5.3 — Testing
- [x] Tulis unit test untuk Model & helper function
- [x] Tulis feature test untuk setiap route penting
- [x] Test semua form validation
- [x] Test role-based access control
- [x] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [x] Mobile responsiveness testing

---

## 📌 Fase 6: Deployment (Minggu 15-16)

### Tugas 6.1 — Persiapan Production
- [x] Set APP_DEBUG=false dan APP_ENV=production
- [x] Jalankan php artisan config:cache, 
oute:cache, iew:cache
- [x] Setup SSL/HTTPS (dokumentasi di DEPLOYMENT.md)
- [x] Konfigurasi .env production
- [x] Setup backup otomatis database

### Tugas 6.2 — Migrasi Data
- [x] Buat script migrasi data dari database lama ke baru
- [x] Migrasi semua file gambar/media ke Laravel Storage
- [ ] Verifikasi integritas data setelah migrasi
- [x] Setup redirect dari URL lama ke URL baru (301 redirect)

### Tugas 6.3 — Go Live
- [ ] Deploy ke server production
- [ ] Test semua fitur di production
- [ ] Monitor error log 48 jam pertama
- [x] Dokumentasi deployment process

---

## 📚 Referensi Belajar

### PHP Modern
- [PHP: The Right Way](https://phptherightway.com/)
- [PHP 8.x New Features](https://www.php.net/releases/8.0/)
- [PSR Standards](https://www.php-fig.org/psr/)

### Laravel
- [Laravel Documentation](https://laravel.com/docs)
- [Laracasts](https://laracasts.com/) (video tutorial)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)

### Keamanan
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)

### Frontend
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/) (untuk interaktivitas ringan)

---

## ⚡ Aturan Coding

1. **Naming Convention:**
   - Controller: PascalCase (contoh: ProductController)
   - Model: PascalCase singular (contoh: Product)
   - Tabel database: snake_case plural (contoh: products)
   - Variable & function: camelCase (contoh: getProductList)
   - Route name: dot.notation (contoh: products.index)

2. **Git Workflow:**
   - Branch main = production ready
   - Branch develop = development
   - Branch eature/* = fitur baru (contoh: eature/product-crud)
   - Commit message: [tipe] deskripsi singkat (contoh: [feat] tambah halaman produk)
   - Pull Request wajib review sebelum merge

3. **Code Quality:**
   - Gunakan Laravel Pint untuk formatting
   - Semua input harus divalidasi (Form Request)
   - Semua output harus di-escape
   - Gunakan Eloquent ORM, hindari raw query
   - Jangan hardcode credential — gunakan .env
   - Setiap fitur baru harus ada testnya

---

## 📊 Checklist Progress

Gunakan checklist ini untuk tracking progress:

### Fase 1: Analisis
- [x] Setup environment lokal
- [x] Website legacy berjalan di lokal
- [x] Dokumen mapping fitur selesai
- [x] Dokumen audit keamanan selesai

### Fase 2: Setup
- [x] Project Laravel ter-inisialisasi
- [x] Semua migration selesai
- [x] Authentication berfungsi
- [x] Seeder & data import berjalan

### Fase 3: Backend
- [x] Semua Model & relasi selesai
- [x] Semua controller frontend selesai
- [x] Semua controller admin selesai
- [x] Validasi & error handling lengkap

### Fase 4: Frontend
- [x] Layout responsive selesai
- [x] Semua halaman frontend selesai
- [x] Admin panel selesai
- [x] Rich text editor terintegrasi

### Fase 5: Optimasi
- [x] SEO terimplementasi
- [x] Email & notifikasi berfungsi
- [x] Testing selesai (150 tests, 332 assertions)

### Fase 6: Deployment
- [x] Migrasi data selesai
- [ ] Website live di production
- [ ] Monitoring aktif

---

> 💡 **Tips:** Mulai dari yang paling dasar (Fase 1 & 2), pastikan fondasi kuat sebelum lanjut ke development. Jangan skip audit keamanan — ini penting untuk memahami kesalahan yang tidak boleh diulang.

---

*Dokumen ini dibuat: 03 Juli 2026*
*Terakhir diperbarui: 22 Juli 2026*
