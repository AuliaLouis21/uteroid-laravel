## Temuan Audit

### 1. Multiple Database Connection

Lokasi:
- site/config.php
- site/views/header.php
- site/func/menu.php

Dampak:
- Terjadi banyak koneksi MySQL yang tidak perlu.
- Menyebabkan error:
  - Too many connections
  - MySQL server has gone away

Rekomendasi:
- Gunakan satu koneksi database terpusat.
- Pada Laravel gunakan konfigurasi melalui .env dan Database Connection bawaan.