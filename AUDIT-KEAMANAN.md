# AUDIT KEAMANAN — Codebase Legacy Utero Group

> **Project:** Modernisasi Website uterogroup.com
> **Codebase Legacy:** `utero-group-dev/` (backup 02 Juli 2026)
> **Tanggal Audit:** 16 Juli 2026
> **Total Kerentanan:** 120+

---

## Ringkasan Eksekutif

| # | Kategori | Severity | Jumlah |
|---|----------|----------|--------|
| 1 | SQL Injection | CRITICAL | 42+ |
| 2 | Cross-Site Scripting (XSS) | HIGH | 50+ |
| 3 | Hardcoded Credentials | CRITICAL | 5 lokasi |
| 4 | Unrestricted File Upload | CRITICAL | 1 fully open, 5 weak |
| 5 | Missing CSRF Protection | HIGH | Semua form (0 token) |
| 6 | Weak Session Management | HIGH | 3 file |
| 7 | Deprecated PHP Functions | MEDIUM | 30+ panggilan |
| 8 | Information Disclosure | MEDIUM | 3 file |

**Kesimpulan:** Codebase ini **TIDAK AMAN** untuk digunakan di production. Semua kerentanan di atas harus diperbaiki melalui migrasi ke Laravel.

---

## 1. SQL Injection (CRITICAL -- 42+ instance)

### 1a. Fungsi `amankan()` Rusak

Fungsi escape utama di kedua modul **tidak berfungsi** karena memanggil `mysql_real_escape_string()` **tanpa parameter koneksi database**.

**File:** `site/func/func.php:39-44`
```php
function amankan($dt){
    $dts = mysql_real_escape_string($dt); // TANPA $konek!
    return $dts;
}
```

**File:** `cms/func/func.php:13-17`
```php
function amankan($dt){
    $dts = mysql_real_escape_string($dt); // TANPA $konek!
    return $dts;
}
```

**Dampak:** SEMUA controller yang menggunakan `amankan()` tetap rentan SQL Injection karena fungsi ini gagal melakukan escape.

### 1b. File yang Terdampak (menggunakan `amankan()`)

| File | Baris | Query |
|------|-------|-------|
| `site/coding/order.php` | 7-8, 24, 32-35, 68, 104 | INSERT, SELECT, UPDATE |
| `site/coding/download.php` | 3-5, 18 | SELECT |
| `site/coding/produk.php` | 4-5, 10, 15, 18, 30, 36, 44 | SELECT |
| `site/coding/cat.php` | 4-5 | SELECT |
| `site/coding/news.php` | 4-5, 15 | SELECT |
| `site/coding/gallery.php` | 4-5, 15 | SELECT |
| `site/coding/video.php` | 4-5, 16, 28 | SELECT |
| `site/coding/audio.php` | 4-5, 16, 28 | SELECT |
| `site/coding/picture.php` | 4-5, 15, 26 | SELECT |
| `site/coding/pertamax.php` | 4-5, 27 | SELECT |
| `site/coding/pages.php` | 4-5 | SELECT |

### 1c. Input User Langsung ke Query (Tanpa Escape)

| File | Baris | Vector | Query Type |
|------|-------|--------|------------|
| `site/coding/testimonial.php` | 40-41, 54-56 | `$_POST['mail']`, `$_POST['nama']`, `$_POST['testinya']` | INSERT |
| `site/coding/ads.php` | 3 | `$_GET['ads']` | SELECT |
| `cms/coding/pages.php` | 28-29, 65 | `$_POST['judul']`, `$_POST['isinya']` | INSERT, UPDATE |
| `cms/coding/posts.php` | 33-34, 81-82 | `$_POST['judul']`, `$_POST['isinya']` | INSERT |
| `cms/coding/catalog.php` | 107-129, 172-176, 209-215 | `$_POST['nama']`, `$_POST['descript']` | INSERT |
| `cms/coding/setting.php` | 39, 63 | `$_POST['passlama']`, `$_POST['user']` | SELECT, UPDATE |
| `cms/coding/order.php` | 10-13 | `$_POST['del']` | DELETE |
| `cms/login/loginact.php` | 39 | `$_POST['user']`, `$_POST['pass']` | SELECT |
| `cms/js/cms/coding/posts.php` | 33-34, 81-82 | `$_POST['judul']`, `$_POST['isinya']` | INSERT |
| `cms/js/cms/coding/catalog.php` | 107-129, 231, 248 | `$_POST['nama']`, `$_POST['del']` | INSERT, DELETE |
| `cms/js/cms/coding/gallery.php` | 72-73 | `$_POST['nama']`, `$_POST['descript']` | INSERT |
| `gramfox/migrate.php` | 30 | `$_POST` values | UPDATE |

---

## 2. Cross-Site Scripting (XSS) (HIGH -- 50+ instance)

Hampir semua view file menampilkan data dari database / input user **tanpa escape** (`htmlspecialchars()`).

### Frontend XSS (Stored & Reflected)

| File | Baris | Variabel | Context |
|------|-------|----------|---------|
| `site/views/header.php` | 15 | `$dtk[1]` | Meta keywords |
| `site/views/kanan.php` | 7-8, 28, 34 | `$dpro['5']`, `$ads` | HTML output |
| `site/views/order/order.php` | 19, 23, 27, 31, 35 | `$_SESSION` values | Form value attributes |
| `site/views/order/order.f.php` | 2 | `$_POST['mail']` | Direct HTML output |
| `site/views/testimonial/testimonial.php` | 9-10, 22, 27 | `$dt['1']`, `$_POST['nama']` | HTML output |
| `site/views/video/video.php` | 18-20 | `$vid[1]`, `$vid['6']` | HTML attributes |
| `site/views/video/video.detil.php` | 2, 6, 14 | `$pi['1']`, `$pi['3']` | HTML output |
| `site/views/news/news.php` | 10 | `$dt[1]`, `$dt[5]` | HTML output |
| `site/views/news/news.detil.php` | 2-4 | `$dt[1]`, `$dt[2]` | Stored XSS (berita) |
| `site/views/picture/picture.php` | 17-19, 35 | `$pic['1']`, `$dtx[1]` | HTML output |
| `site/views/picture/picture.detil.php` | 2, 5, 48 | `$pi['1']`, `$pi['2']` | HTML output |
| `site/views/gallery/gallery.php` | 9-11, 32-33 | `$pic['1']`, `$vid[1]` | HTML output |
| `site/views/produk/produk.php` | 35, 38 | `$dtr['1']` | HTML output |
| `site/views/produk/produk.detil.php` | 2, 4, 26 | `$dt['1']`, `$dt[6]` | Stored XSS (deskripsi produk) |
| `site/views/pages/pages.php` | 2-3 | `$title`, `$dt['2']` | Stored XSS (konten halaman) |
| `site/views/pertamax/pertamax.php` | 11-14 | `$dt[1]` | HTML output |
| `site/views/pertamax/pertamax-slide.php` | 13 | `$dtsl['1']` | HTML output |

### CMS Admin XSS (Stored)

| File | Baris | Variabel | Context |
|------|-------|----------|---------|
| `cms/views/posts/posts.c.php` | 7, 11 | `$dt[1]`, `$dt[2]` | Form value/textarea |
| `cms/views/pages/pages.c.php` | 7, 12 | `$dt[1]`, `$dt[2]` | Form value/textarea |
| `cms/views/order/order.d.php` | 5-52 | `$dt['1']` - `$dt['10']` | Customer PII output |
| `cms/views/setting/setting.pass.php` | 4-5, 14, 31 | `$m`, `$dt['0']` | Error messages + form values |
| `cms/views/catalog/catalog.c.php` | 32, 37, 48, 54, 60, 65 | `$_POST['nama']`, `$_POST['size']` | Form values on error |

---

## 3. Hardcoded Credentials (CRITICAL)

### Database Credentials (4 lokasi berbeda)

| File | Baris | User | Password | Database |
|------|-------|------|----------|----------|
| `site/config.php` | 3-4 | `uteroid_dbuser` | `lL!-A8UzZRv6` | `uteroid_cms` |
| `cms/config.php` | 3-4 | `uteroid_dbuser` | `lL!-A8UzZRv6` | `uteroid_cms` |
| `cms/js/cms/config.php` | 3-4 | `uteroadv_uteroad` | `!@#$%^` | `uteroadv_uteroadv` |
| `gramfox/migrate.php` | 3-6 | `uteroadv_uteroad` | `!@#$%^` | `uteroid_simpusat` |

### Plaintext Passwords di SQL Dump

**File:** `sql/uteroid_cms.sql` -- berisi password admin dalam plain text:

| Tabel | Username | Password |
|-------|----------|----------|
| `admin` | `admin` | `123456` |
| `logmin` | `adminutero` | `DADIKWAHYUKU12` |
| `logmin` | `ruvodo` | `ruvodoweb123` |

### Secrets Lainnya

| File | Item | Detail |
|------|------|--------|
| `site/views/header.php` | Google Analytics ID | `UA-125639391-28` |
| `site/views/contact/contact.php` | Yahoo Messenger IDs | `utero_adm`, `marketing_utero` |

---

## 4. Unrestricted File Upload (CRITICAL)

### Fully Open -- Tanpa Autentikasi

**File:** `gramfox/upload.php`
- Tidak ada session check / autentikasi
- Tidak ada validasi extension
- Tidak ada limit ukuran file
- **Dampak:** Remote Code Execution -- siapapun bisa upload file PHP ke server

### Weak Validation -- Autentikasi Ada, Tapi Bisa Dikalahkan

| File | Issue |
|------|-------|
| `cms/coding/ads.php` | Cek extension (`jpg`, `gif`) saja, filename tidak di-sanitize |
| `cms/coding/catalog.php` | Cek extension `jpg` saja, filename dari user slug tanpa path traversal check |
| `cms/coding/upload.php` | Validasi extension lemah |
| `cms/js/cms/coding/gallery.php` | Cek extension `jpg`, limit 2MB, tapi filename dari slug |

---

## 5. Missing CSRF Protection (HIGH)

**Seluruh form** di aplikasi ini (frontend + CMS admin) **tidak memiliki CSRF token**.

| Form | File | Risk |
|------|------|------|
| Order submission | `site/views/order/order.php` | Customer bisa disesatkan |
| Testimonial submission | `site/views/testimonial/testimonial.php` | Spam/forged testimonials |
| Admin password change | `cms/views/setting/setting.pass.php` | Account takeover |
| Admin settings | `cms/views/setting/setting.set.php` | Settings tampering |
| Post/Page CRUD | `cms/views/posts/posts.c.php`, `cms/views/pages/pages.c.php` | Content injection |
| Product CRUD | `cms/views/catalog/catalog.c.php` | Data manipulation |
| Batch delete | Semua CMS delete forms | Mass deletion |

---

## 6. Weak Session Management (HIGH)

| File | Baris | Issue |
|------|-------|-------|
| `cms/index.php` | 10 | `if (!$_SESSION['root'])` -- pengecekan session tanpa regeneration |
| `cms/js/cms/index.php` | 9 | Sama -- pengecekan minimal |
| `cms/login/loginact.php` | 43 | Token session statis: `$_SESSION['root'] = "utero_cms_"` -- tidak di-regenerate saat login |
| `cms/login/loginact.php` | 39 | **Plaintext password comparison:** `if($dt['2']==$_POST['pass'])` -- tanpa hash |

---

## 7. Deprecated PHP Functions (MEDIUM -- 30+ panggilan)

| Function | Jumlah | File | Catatan |
|----------|--------|------|---------|
| `mysql_connect()` | 3 | `cms/config.php`, `cms/js/cms/config.php`, `gramfox/migrate.php` | Dihapus di PHP 7.0 |
| `mysql_select_db()` | 2 | `cms/config.php`, `cms/js/cms/config.php` | Dihapus di PHP 7.0 |
| `mysql_query()` | 30+ | `cms/coding/*.php`, `cms/js/cms/coding/*.php` | Dihapus di PHP 7.0 |
| `mysql_fetch_array()` | 25+ | `site/views/**/*.php`, `cms/views/**/*.php` | Dihapus di PHP 7.0 |
| `mysql_num_rows()` | 10+ | Multiple CMS files | Dihapus di PHP 7.0 |
| `mysql_insert_id()` | 1 | `cms/js/cms/coding/catalog.php` | Dihapus di PHP 7.0 |
| `ereg_replace()` | 12+ | `cms/js/cms/coding/*.php` | Dihapus di PHP 7.0 |
| Short open tag `<?` | 1 | `site/func/com_terbilang.php` | Non-standar |

---

## 8. Information Disclosure (MEDIUM)

| File | Issue |
|------|-------|
| `index.php` | `error_reporting(E_ALL)` + `display_errors = On` di production |
| `cms/index.php` | `ini_set("display_errors", 1)` |
| `cms/js/cms/index.php` | `ini_set("display_errors", 1)` |
| Multiple files | `or die(mysql_error())` -- SQL error detail bocor ke user |

---

## 9. Teknologi Usang & Deprecated (LOW)

| Teknologi | File | Status |
|-----------|------|--------|
| Yahoo Messenger | `site/views/contact/contact.php`, `gallery/galdetil.php` | YM tutup 2018 |
| Flash Player | `site/views/gallery/gallery.php:54`, `site/func/youtube.class.php` | Flash EOL Des 2020 |
| `<blink>` tag | `cms/views/order/order.d.php:25` | Deprecated sejak HTML5 |
| Google Analytics UA | `site/views/header.php` | UA deprecated, harus migrasi ke GA4 |

---

## Database Schema (21 Tabel -- MyISAM)

| Tabel | Deskripsi | Issue |
|-------|-----------|-------|
| `admin` | User admin | Plain-text password |
| `ads` | Konten iklan | -- |
| `albumpic` | Album foto | -- |
| `audgal` | Galeri audio | -- |
| `category` | Kategori umum | -- |
| `catproduk` | Kategori produk | -- |
| `dataupload` | File upload | Tidak ada validasi |
| `image` | Gambar produk | -- |
| `jnsproduk` | Jenis produk | -- |
| `logmin` | Log admin | Plaintext password |
| `logminfo` | Log info admin | -- |
| `member` | Member/pelanggan | -- |
| `order` | Detail order | PII tanpa proteksi |
| `orderuser` | Data user order | -- |
| `page` | Halaman statis | -- |
| `pictgal` | Galeri gambar | -- |
| `posts` | Berita/artikel | -- |
| `produk` | Data produk | -- |
| `setting` | Pengaturan website | -- |
| `testi` | Testimonial | -- |
| `videogal` | Galeri video | -- |

---

## Rekomendasi Remediation

### Prioritas 1 -- Harus Diperbaiki Sekarang
1. Ganti SEMUA password database, pindahkan ke `.env`
2. Hapus atau batasi akses ke `sql/uteroid_cms.sql` (berisi password + PII)
3. Hapus atau kunci `gramfox/upload.php` dan `gramfox/migrate.php`
4. Perbaiki fungsi `amankan()` -- tambahkan parameter `$konek`

### Prioritas 2 -- Minggu Ini
5. Escape semua output dengan `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`
6. Tambahkan CSRF token ke semua form
7. Perbaiki SQL injection di semua CMS controller
8. Matikan `display_errors` di production
9. Implementasi session management yang benar

### Prioritas 3 -- Bulan Ini
10. Migrasi dari `mysql_*` ke `mysqli_*` atau PDO
11. Ganti `ereg_replace()` dengan `preg_replace()`
12. Hash password dengan `password_hash()` / bcrypt
13. Tambahkan autentikasi ke semua file upload handler

### Prioritas 4 -- Rencana Jangka Panjang
14. Upgrade PHP version (target: PHP 8.x)
15. Konsolidasi 3 aplikasi (site/cms/admin) ke satu framework
16. Ganti CodeIgniter 1.x dengan framework modern (Laravel)
17. Hapus semua dependensi Flash dan Yahoo Messenger

---

> **Catatan:** Semua temuan di atas sudah diverifikasi dengan membaca seluruh file PHP di codebase legacy. Total kerentanan unik melebihi 120 instance.

*Dokumen ini dibuat: 16 Juli 2026*
