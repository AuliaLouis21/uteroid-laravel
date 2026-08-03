# 📋 CHANGELOG — Perubahan 3 Agustus 2026

> **Commit:** `7e3d5d5`
> **Judul:** feat: product min order, size/area fields, contact messages, and caching refinements
> **Tanggal:** 3 Agustus 2026
> **Jumlah File:** 47 files changed (+1,380 lines, -52 lines)

---

## 📑 Daftar Isi

1. [Ringkasan Perubahan](#1-ringkasan-perubahan)
2. [Fitur Baru](#2-fitur-baru)
3. [Database Changes](#3-database-changes)
4. [API Changes](#4-api-changes)
5. [Admin Panel Changes](#5-admin-panel-changes)
6. [Frontend Changes](#6-frontend-changes)
7. [Performance & Security](#7-performance--security)
8. [Testing Updates](#8-testing-updates)
9. [Migration Instructions](#9-migration-instructions)
10. [Breaking Changes](#10-breaking-changes)

---

## 1. Ringkasan Perubahan

### 1.1 Fitur Utama yang Ditambahkan

| Fitur | Deskripsi | Status |
|-------|-----------|--------|
| **Contact Messages CMS** | Sistem manajemen pesan kontak di admin panel | ✅ Baru |
| **Product Size Unit** | Satuan perhitungan ukuran (cm²/m²) untuk produk | ✅ Baru |
| **Order Area Calculation** | Kalkulasi luas otomatis berdasarkan panjang × lebar | ✅ Baru |
| **Min Order Validation** | Validasi jumlah order minimal per produk | ✅ Baru |
| **Gallery Lightbox** | Modal lightbox untuk foto galeri dengan navigasi | ✅ Baru |
| **Album Photo Caption Edit** | Edit caption foto langsung dari admin | ✅ Baru |

### 1.2 File yang Berubah

```
New Files (10):
├── add-vhost-host.bat
├── app/Http/Controllers/Admin/ContactMessageController.php
├── app/Models/ContactMessage.php
├── database/factories/ContactMessageFactory.php
├── database/migrations/2026_08_01_000001_create_contact_messages_table.php
├── database/migrations/2026_08_01_100000_add_size_unit_to_products_and_size_to_order_items.php
├── resources/views/admin/contact-messages/index.blade.php
├── resources/views/admin/contact-messages/show.blade.php
├── tests/Feature/AdminContactMessageTest.php
├── tests/Feature/ContactFormTest.php

Modified Files (37):
├── app/Http/Controllers/Admin/AlbumController.php
├── app/Http/Controllers/Admin/DashboardController.php
├── app/Http/Controllers/Api/V1/ContactController.php
├── app/Http/Controllers/Api/V1/OrderController.php
├── app/Http/Controllers/ContactController.php
├── app/Http/Controllers/OrderController.php
├── app/Http/Middleware/CacheHeaders.php
├── app/Http/Requests/Admin/StoreProductRequest.php
├── app/Http/Requests/Admin/UpdateProductRequest.php
├── app/Http/Requests/OrderRequest.php
├── app/Models/Order.php
├── app/Models/OrderItem.php
├── app/Models/Product.php
├── app/Models/ProductImage.php
├── app/Services/WhatsAppService.php
├── database/factories/ProductFactory.php
├── resources/views/admin/albums/edit.blade.php
├── resources/views/admin/dashboard.blade.php
├── resources/views/admin/orders/index.blade.php
├── resources/views/admin/orders/show.blade.php
├── resources/views/admin/products/create.blade.php
├── resources/views/admin/products/edit.blade.php
├── resources/views/admin/products/index.blade.php
├── resources/views/admin/products/show.blade.php
├── resources/views/emails/admin-order-notification.blade.php
├── resources/views/emails/order-received.blade.php
├── resources/views/gallery/photos.blade.php
├── resources/views/layouts/admin.blade.php
├── resources/views/orders/create.blade.php
├── routes/web.php
├── tests/Feature/AdminAlbumTest.php
├── tests/Feature/AdminProductTest.php
├── tests/Feature/Api/ContactApiTest.php
├── tests/Feature/Api/OrderApiTest.php
├── tests/Feature/OrderFormTest.php
├── tests/Unit/OrderTest.php
├── tests/Unit/ProductTest.php
```

---

## 2. Fitur Baru

### 2.1 Contact Messages CMS

**Tujuan:** Menyimpan semua pesan kontak dari form publik ke database agar dapat dikelola di admin panel.

#### Database Table: `contact_messages`

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| `id` | bigint (PK) | No | auto | ID pesan |
| `name` | varchar(255) | No | — | Nama pengirim |
| `email` | varchar(255) | No | — | Email pengirim |
| `phone` | varchar(255) | Ya | null | Telepon pengirim |
| `subject` | varchar(255) | No | — | Subjek pesan |
| `message` | text | No | — | Isi pesan |
| `status` | enum | No | `new` | Status: new/read/replied |
| `created_at` | timestamp | No | — | Waktu dibuat |
| `updated_at` | timestamp | No | — | Waktu diupdate |

#### Model: `ContactMessage`

```php
// app/Models/ContactMessage.php
class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
```

#### Controller: `ContactMessageController`

```php
// app/Http/Controllers/Admin/ContactMessageController.php
class ContactMessageController extends Controller
{
    // Index dengan filter status
    public function index(Request $request) { ... }

    // Detail pesan
    public function show(ContactMessage $contactMessage) { ... }

    // Update status (new/read/replied)
    public function update(Request $request, ContactMessage $contactMessage) { ... }

    // Hapus pesan
    public function destroy(ContactMessage $contactMessage) { ... }
}
```

#### Routes

```php
// routes/web.php
Route::resource('contact-messages', ContactMessageController::class)
    ->only(['index', 'show', 'update', 'destroy']);
```

**Route Names:**
- `admin.contact-messages.index`
- `admin.contact-messages.show`
- `admin.contact-messages.update`
- `admin.contact-messages.destroy`

#### Integrasi dengan Form Publik

**Form Web (`ContactController`):**
```php
public function send(ContactRequest $request)
{
    ContactMessage::create(array_merge($request->validated(), [
        'status' => 'new',
    ]));
    // ... kirim email
}
```

**API (`ContactController`):**
```php
public function store(Request $request): JsonResponse
{
    // ... validasi
    ContactMessage::create(array_merge($validated, [
        'status' => 'new',
    ]));
    // ... kirim email
}
```

---

### 2.2 Product Size Unit & Area Calculation

**Tujuan:** Mendukung produk yang dihitung berdasarkan luas (m² atau cm²) bukan quantity.

#### Database Changes

**Tabel `products` — Kolom Baru:**

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| `size_unit` | varchar(255) | Ya | null | `cm2` atau `m2` |

**Tabel `order_items` — Kolom Baru:**

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| `length_cm` | decimal(12,2) | Ya | null | Panjang dalam cm |
| `width_cm` | decimal(12,2) | Ya | null | Lebar dalam cm |
| `area` | decimal(15,4) | Ya | null | Luas hasil kalkulasi |
| `size_unit` | varchar(255) | Ya | null | `cm2` atau `m2` |

#### Model Updates

**Product Model:**
```php
// app/Models/Product.php
protected $fillable = [
    // ... existing fields
    'size_unit',  // NEW
];

public function getHasSizeUnitAttribute(): bool
{
    return in_array($this->size_unit, ['m2', 'cm2'], true);
}

public function getSizeUnitLabelAttribute(): string
{
    return $this->size_unit === 'm2' ? 'm²' : 'Cm²';
}
```

**OrderItem Model:**
```php
// app/Models/OrderItem.php
protected $fillable = [
    // ... existing fields
    'length_cm', 'width_cm', 'area', 'size_unit',  // NEW
];

protected $casts = [
    'quantity' => 'integer',
    'length_cm' => 'decimal:2',
    'width_cm' => 'decimal:2',
    'area' => 'decimal:4',
    'unit_price' => 'decimal:2',
    'total_price' => 'decimal:2',
];

public function getHasSizeAttribute(): bool
{
    return $this->size_unit !== null && $this->area !== null;
}

public function getSizeUnitLabelAttribute(): string
{
    return $this->size_unit === 'm2' ? 'm²' : 'Cm²';
}
```

#### Area Calculation Logic

```php
// app/Http/Controllers/OrderController.php
protected function calculateArea(float $lengthCm, float $widthCm, ?string $sizeUnit): ?float
{
    if ($lengthCm <= 0 || $widthCm <= 0 || !in_array($sizeUnit, ['m2', 'cm2'], true)) {
        return null;
    }

    return $sizeUnit === 'm2'
        ? ($lengthCm * $widthCm) / 10000  // cm² → m²
        : $lengthCm * $widthCm;            // tetap cm²
}
```

**Contoh Kalkulasi:**

| Ukuran Input | Size Unit | Hasil Area |
|--------------|-----------|------------|
| 120 cm × 80 cm | `cm2` | 9,600 cm² |
| 120 cm × 80 cm | `m2` | 0.96 m² |
| 200 cm × 100 cm | `m2` | 2.00 m² |

---

### 2.3 Minimum Order Validation

**Tujuan:** Memastikan jumlah order sesuai minimum yang ditentukan per produk.

#### Validation Logic

```php
// app/Http/Requests/OrderRequest.php
'items.*.quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
    if (!preg_match('/items\.(\d+)\.quantity/', $attribute, $m)) {
        return;
    }

    $productId = $this->input("items.{$m[1]}.product_id");
    if (! $productId) {
        return;
    }

    $product = Product::find($productId);
    if ($product && $value < $product->min_order) {
        $fail("Jumlah order minimal {$product->min_order} untuk {$product->name}.");
    }
}],
```

**Error Message:**
```
"Jumlah order minimal 100 untuk Spanduk Banner."
```

---

### 2.4 Gallery Lightbox

**Tujuan:** Menampilkan foto galeri dalam modal lightbox dengan navigasi.

#### Fitur

- Klik foto untuk membuka lightbox
- Navigasi prev/next dengan tombol panah
- Tampilkan caption/keterangan foto
- Tekan ESC atau klik X untuk menutup
- Responsive (mobile & desktop)

#### Implementation

```php
// resources/views/gallery/photos.blade.php
<div x-data="galleryLightbox()">
    {{-- Foto grid --}}
    @foreach($album->photos as $photo)
        <div class="gallery-item cursor-pointer" @click="open({{ $photo->id }})">
            <img src="{{ asset('storage/' . $photo->filename) }}" loading="lazy">
        </div>
    @endforeach

    {{-- Lightbox modal --}}
    <div x-show="active" x-cloak x-transition.opacity class="fixed inset-0 z-50">
        <img :src="active.src">
        <button @click="prev()"><i class="fas fa-chevron-left"></i></button>
        <button @click="next()"><i class="fas fa-chevron-right"></i></button>
        <div x-text="active.caption"></div>
    </div>
</div>
```

---

### 2.5 Album Photo Caption Edit

**Tujuan:** Mengedit caption/foto langsung dari admin panel.

#### Route

```php
Route::patch('albums/{album}/photos/{photo}', [AlbumController::class, 'updatePhoto'])
    ->name('albums.photos.update');
```

#### Controller

```php
// app/Http/Controllers/Admin/AlbumController.php
public function updatePhoto(Request $request, Album $album, AlbumPhoto $photo)
{
    $data = $request->validate([
        'caption' => ['nullable', 'string', 'max:255'],
    ]);

    $photo->update($data);

    Cache::forget('gallery.albums');

    return redirect()->route('admin.albums.edit', $album)
        ->with('success', 'Keterangan foto berhasil diperbarui.');
}
```

---

## 3. Database Changes

### 3.1 New Migration: Contact Messages

**File:** `database/migrations/2026_08_01_000001_create_contact_messages_table.php`

```php
Schema::create('contact_messages', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('phone')->nullable();
    $table->string('subject');
    $table->text('message');
    $table->enum('status', ['new', 'read', 'replied'])->default('new');
    $table->timestamps();
});
```

### 3.2 New Migration: Size Fields

**File:** `database/migrations/2026_08_01_100000_add_size_unit_to_products_and_size_to_order_items.php`

```php
// Products table
Schema::table('products', function (Blueprint $table) {
    $table->string('size_unit')->nullable()->after('size');
});

// Order items table
Schema::table('order_items', function (Blueprint $table) {
    $table->decimal('length_cm', 12, 2)->nullable()->after('quantity');
    $table->decimal('width_cm', 12, 2)->nullable()->after('length_cm');
    $table->decimal('area', 15, 4)->nullable()->after('width_cm');
    $table->string('size_unit')->nullable()->after('area');
});
```

### 3.3 Backfill Data

Migration ini juga melakukan backfill otomatis untuk produk yang sudah ada:

```php
protected function backfillSizeUnit(): void
{
    $products = DB::table('products')
        ->whereNull('size_unit')
        ->whereNotNull('size')
        ->get(['id', 'size']);

    foreach ($products as $product) {
        $unit = $this->inferUnit($product->size);
        if ($unit) {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['size_unit' => $unit]);
        }
    }
}

protected function inferUnit(?string $size): ?string
{
    if (empty($size)) {
        return null;
    }

    if (stripos($size, 'cm') !== false) {
        return 'cm2';
    }

    if (preg_match('/\bm\b/i', $size)) {
        return 'm2';
    }

    return null;
}
```

**Contoh Backfill:**

| Size (existing) | Inferred Unit |
|-----------------|---------------|
| `30x40cm` | `cm2` |
| `40x60cm` | `cm2` |
| `2m x 1m` | `m2` |
| `50x70` | null (tidak bisa infer) |

---

## 4. API Changes

### 4.1 Order API — Request Body

**Endpoint:** `POST /api/v1/orders`

**Request Body (Updated):**

```json
{
    "name": "Budi",
    "email": "budi@example.com",
    "phone": "081234567890",
    "city": "Malang",
    "address": "Jl. Merdeka No. 1",
    "items": [
        {
            "product_id": 1,
            "product_name": "Spanduk Banner",
            "quantity": 100,
            "length_cm": 120,    // NEW (optional)
            "width_cm": 80       // NEW (optional)
        }
    ]
}
```

**Validation Rules (Updated):**

```php
'items' => 'required|array|min:1',
'items.*.product_id' => 'nullable|exists:products,id',
'items.*.product_name' => 'required|string|max:255',
'items.*.quantity' => ['required', 'integer', 'min:1', /* min_order validation */],
'items.*.length_cm' => 'nullable|numeric|min:0',  // NEW
'items.*.width_cm' => 'nullable|numeric|min:0',   // NEW
```

**Response (201 Created):**

```json
{
    "message": "Order created successfully",
    "data": {
        "id": 1,
        "name": "Budi",
        "email": "budi@example.com",
        "phone": "081234567890",
        "city": "Malang",
        "address": "Jl. Merdeka No. 1",
        "status": "pending",
        "items": [
            {
                "id": 1,
                "product_id": 1,
                "product_name": "Spanduk Banner",
                "quantity": 100,
                "length_cm": 120,
                "width_cm": 80,
                "area": 9600,
                "size_unit": "cm2",
                "unit_price": 50000,
                "total_price": 5000000
            }
        ],
        "created_at": "2026-08-03T10:00:00.000000Z"
    }
}
```

### 4.2 Contact API — No Changes

**Endpoint:** `POST /api/v1/contact`

**Request Body (Tidak Berubah):**

```json
{
    "name": "Budi",
    "email": "budi@example.com",
    "phone": "081234567890",
    "subject": "Konsultasi",
    "message": "Saya ingin konsultasi tentang spanduk"
}
```

**Perubahan Internal:**
- Sekarang pesan disimpan ke database (`contact_messages` table)
- Sebelumnya hanya mengirim email

---

## 5. Admin Panel Changes

### 5.1 Dashboard Updates

**File:** `resources/views/admin/dashboard.blade.php`

**Perubahan:**

1. **Stat Card Baru — Pesan Kontak:**
```html
<div class="col-md-4 col-lg">
    <a href="{{ route('admin.contact-messages.index') }}" class="text-decoration-none">
        <div class="card text-bg-primary">
            <div class="card-body d-flex align-items-center">
                <div class="me-3" style="font-size:2rem;">&#9993;</div>
                <div>
                    <h6 class="card-title mb-0">Pesan Kontak</h6>
                    <h2 class="mb-0">{{ $stats['contact_messages'] }}</h2>
                </div>
            </div>
        </div>
    </a>
</div>
```

2. **Recent Pesan Kontak Widget:**
```html
<div class="col-md-3 mb-4">
    <div class="card h-100">
        <div class="card-header">Recent Pesan Kontak</div>
        <div class="card-body">
            @if($recentContactMessages->isEmpty())
                <p class="text-muted mb-0">No messages yet.</p>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($recentContactMessages as $message)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="{{ route('admin.contact-messages.show', $message) }}">
                                {{ $message->name }} - {{ $message->subject }}
                            </a>
                            <span class="badge bg-{{ $message->status === 'new' ? 'warning' : ($message->status === 'read' ? 'info' : 'success') }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
```

### 5.2 Navigation Updates

**File:** `resources/views/layouts/admin.blade.php`

**Added Menu Item:**

```html
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
       href="{{ route('admin.contact-messages.index') }}">Pesan Kontak</a>
</li>
```

### 5.3 Product Management Updates

**Create/Edit Forms — Fields Baru:**

```html
{{-- Ukuran --}}
<div class="col-md-6 mb-3">
    <label for="size" class="form-label">Ukuran</label>
    <input type="text" name="size" id="size" class="form-control"
           value="{{ old('size') }}" placeholder="cth: 40x30 cm">
</div>

{{-- Satuan Perhitungan Order --}}
<div class="col-md-6 mb-3">
    <label for="size_unit" class="form-label">Satuan Perhitungan Order</label>
    <select name="size_unit" id="size_unit" class="form-select">
        <option value="">-- Tanpa Ukuran (Quantity) --</option>
        <option value="cm2">Cm² (centimeter persegi)</option>
        <option value="m2">m² (meter persegi)</option>
    </select>
    <small class="text-muted">Jika produk dihitung berdasarkan luas, pilih satuannya.</small>
</div>

{{-- Ketebalan --}}
<div class="col-md-6 mb-3">
    <label for="thickness" class="form-label">Ketebalan</label>
    <input type="text" name="thickness" id="thickness" class="form-control"
           value="{{ old('thickness') }}" placeholder="cth: 1 cm">
</div>
```

**Product Index Table — Kolom Baru:**

```html
<th>Ukuran</th>
<th>Ketebalan</th>
```

### 5.4 Order Show Updates

**File:** `resources/views/admin/orders/show.blade.php`

**Updated Table Headers:**

```html
<th>Product</th>
<th>Jumlah Order</th>        <!-- Changed from "Qty" -->
<th>Total Harga Satuan</th>  <!-- Changed from "Unit Price" -->
<th>Total Harga Keseluruhan</th>  <!-- Changed from "Total" -->
```

**Area Display in Order Items:**

```html
<td>
    @if($item->has_size)
        @php
            $areaNum = rtrim(rtrim(number_format((float) $item->area, 4, ',', '.'), '0'), ',');
        @endphp
        {{ $areaNum }} {{ $item->size_unit_label }}
        @if($item->length_cm && $item->width_cm)
            <br><small class="text-muted">{{ $item->length_cm }} x {{ $item->width_cm }} cm</small>
        @endif
    @else
        {{ $item->quantity }}
    @endif
</td>
```

### 5.5 Contact Messages Views

**Index View (`admin/contact-messages/index.blade.php`):**

- Filter buttons: All, New, Read, Replied
- Table with: ID, Name, Subject, Email, Phone, Status, Date, Actions
- Pagination

**Show View (`admin/contact-messages/show.blade.php`):**

- Message content
- Sender info (name, email, phone, subject, date)
- Status update form (new/read/replied)
- Delete button

---

## 6. Frontend Changes

### 6.1 Order Form Updates

**File:** `resources/views/orders/create.blade.php`

**Perubahan Utama:**

1. **Product Selection — Tampilkan Satuan:**
```html
<option value="{{ $product->id }}">
    {{ $product->name }} - Rp. {{ number_format($product->price) }}
    {{ $product->size_unit === 'm2' ? ' (m²)' : ($product->size_unit === 'cm2' ? ' (Cm²)' : '') }}
</option>
```

2. **Size Input Fields (Conditional):**
```html
<template x-if="hasSize(item)">
    <div>
        <div class="w-28">
            <label class="text-xs font-semibold text-gray-500 mb-1 block">Panjang (cm)</label>
            <input type="number" :name="'items[' + index + '][length_cm]'" x-model="item.length_cm"
                   min="0" step="0.01" placeholder="cth: 120">
        </div>
        <div class="w-28 mt-3">
            <label class="text-xs font-semibold text-gray-500 mb-1 block">Lebar (cm)</label>
            <input type="number" :name="'items[' + index + '][width_cm]'" x-model="item.width_cm"
                   min="0" step="0.01" placeholder="cth: 80">
        </div>
    </div>
    <div class="w-36">
        <label class="text-xs font-semibold text-gray-500 mb-1 block"
               x-text="'Jumlah Order (' + unitLabel(item) + ')'">Jumlah Order (m²)</label>
        <div class="px-3 py-2.5 text-sm font-semibold text-brand bg-brand/5 border border-brand/20 rounded-lg"
             x-text="formatArea(item)">0</div>
    </div>
</template>
```

3. **Min Order Display:**
```html
<div class="w-36">
    <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order (Quantity)</label>
    <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity"
           :min="getMinOrder(item.product_id)" @change="clampQuantity(item)">
    <div class="text-[11px] text-gray-400 mt-1" x-text="'Min: ' + getMinOrder(item.product_id)"></div>
</div>
```

4. **Price Display:**
```html
<div class="w-36">
    <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
    <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg"
         x-text="formatCurrency(getProductPrice(item.product_id))">Rp. 0</div>
</div>
```

5. **Grand Total:**
```html
<div class="flex items-center justify-between gap-4 bg-white p-4 rounded-lg border border-gray-200 mb-4">
    <div>
        <span class="text-sm font-semibold text-gray-500">Total Pesanan</span>
        <div class="text-2xl font-bold text-brand" x-text="formatCurrency(grandTotal())">Rp. 0</div>
    </div>
    <div class="flex justify-end">
        <button type="submit" class="form-submit">
            <i class="fas fa-paper-plane"></i>Kirim Pesanan
        </button>
    </div>
</div>
```

**Alpine.js Functions:**

```javascript
function orderForm() {
    return {
        items: [{ product_id: '', product_name: '', quantity: 1, length_cm: '', width_cm: '' }],

        getProductPrice(id) { return productPrices[id] || 0; },
        getSizeUnit(id) { return productSizeUnits[id] || null; },
        getMinOrder(id) { return productMinOrders[id] || 1; },
        hasSize(item) { return !!this.getSizeUnit(item.product_id); },
        unitLabel(item) { return this.getSizeUnit(item.product_id) === 'm2' ? 'm²' : 'Cm²'; },

        onProductChange(item) {
            item.product_name = this.getProductName(item.product_id);
            item.length_cm = '';
            item.width_cm = '';
            item.quantity = this.getMinOrder(item.product_id);
        },

        clampQuantity(item) {
            var min = this.getMinOrder(item.product_id);
            var q = parseInt(item.quantity, 10);
            if (!q || q < min) { item.quantity = min; }
        },

        itemArea(item) {
            var unit = this.getSizeUnit(item.product_id);
            if (!unit) return 0;
            var l = parseFloat(item.length_cm) || 0;
            var w = parseFloat(item.width_cm) || 0;
            var cm2 = l * w;
            return unit === 'm2' ? cm2 / 10000 : cm2;
        },

        formatArea(item) {
            if (!this.hasSize(item)) return '0';
            return Number(this.itemArea(item) || 0).toLocaleString('id-ID') + ' ' + this.unitLabel(item);
        },

        lineTotal(item) {
            return this.getProductPrice(item.product_id) * (parseInt(item.quantity) || 0);
        },

        grandTotal() {
            return this.items.reduce((sum, item) => sum + this.lineTotal(item), 0);
        },

        formatCurrency(value) {
            return 'Rp. ' + Number(value || 0).toLocaleString('id-ID');
        }
    }
}
```

### 6.2 Email Templates Updates

**Files:**
- `resources/views/emails/admin-order-notification.blade.php`
- `resources/views/emails/order-received.blade.php`

**Updated Item Display:**

```html
<td>
    @if($item->has_size)
        {{ rtrim(rtrim(number_format((float) $item->area, 4, ',', '.'), '0'), ',') }} {{ $item->size_unit_label }}
        @if($item->length_cm && $item->width_cm)
            <br><small>({{ $item->length_cm }} x {{ $item->width_cm }} cm)</small>
        @endif
    @else
        {{ $item->quantity }}
    @endif
</td>
```

### 6.3 WhatsApp Message Updates

**File:** `app/Services/WhatsAppService.php`

**Updated Message Format:**

```php
public function buildOrderMessage(Order $order): string
{
    $items = $order->items->map(function ($item) {
        if ($item->has_size) {
            $area = rtrim(rtrim(number_format((float) $item->area, 4, ',', '.'), '0'), ',');
            $size = $item->length_cm && $item->width_cm
                ? " ({$item->length_cm}x{$item->width_cm} cm)"
                : '';

            return "  - {$item->product_name}: {$area} {$item->size_unit_label}{$size} x{$item->quantity}";
        }

        return "  - {$item->product_name} x{$item->quantity}";
    })->implode("\n");
```

**Contoh Output WhatsApp:**

**Tanpa Size:**
```
Pesanan Baru:
  - Spanduk Banner x100
```

**Dengan Size (cm²):**
```
Pesanan Baru:
  - Spanduk Banner: 9.600 Cm² (120x80 cm) x2
```

**Dengan Size (m²):**
```
Pesanan Baru:
  - Spanduk Banner: 2 m² (200x100 cm) x1
```

---

## 7. Performance & Security

### 7.1 Cache Headers Refinement

**File:** `app/Http/Middleware/CacheHeaders.php`

**Perubahan:** Logika cache header diperbaiki menggunakan named routes.

**Before:**
```php
if ($request->is('admin/*') || $request->is('login') || $request->is('register')
    || $request->is('dashboard') || $request->is('profile*')
    || $request->user()) {
    $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
}
```

**After:**
```php
$noStoreRouteNames = [
    'login',
    'register',
    'password.request',
    'password.reset',
    'password.confirm',
    'verification.notice',
    'contact.index',
    'order.create',
    'testimonials.index',
];

if ($request->user()
    || $request->is('admin/*')
    || $request->route()?->named($noStoreRouteNames)) {
    $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
} else {
    $response->headers->set('Cache-Control', 'public, max-age=3600, s-maxage=3600');
}
```

**Routes yang Mendapat `no-store` (Tidak Di-cache):**
- Login, Register, Password Reset
- Contact Form
- Order Form
- Testimonials Form
- Semua Admin Routes
- Halaman yang membutuhkan autentikasi

---

## 8. Testing Updates

### 8.1 New Test Files

**`tests/Feature/AdminContactMessageTest.php` (5 tests):**
- `test_admin_contact_message_index_returns_200`
- `test_admin_contact_message_index_filters_by_status`
- `test_admin_contact_message_show_returns_200`
- `test_admin_contact_message_update_updates_status`
- `test_admin_contact_message_destroy_deletes_message`

**`tests/Feature/ContactFormTest.php` (4 tests):**
- `test_contact_form_returns_200`
- `test_contact_form_validates_required_fields`
- `test_contact_form_stores_message_to_cms`
- `test_contact_form_sends_email`

### 8.2 Updated Test Files

**`tests/Feature/AdminAlbumTest.php` (+2 tests):**
- `test_admin_album_updates_photo_caption`
- `test_admin_album_clears_photo_caption`

**`tests/Feature/AdminProductTest.php` (+1 test):**
- Updated `test_admin_product_store_creates_product` — cek `size` dan `thickness`
- Updated `test_admin_product_update_updates_product` — cek `size` dan `thickness`

**`tests/Feature/Api/ContactApiTest.php` (+1 test):**
- `test_contact_store_stores_message_to_cms`

**`tests/Feature/Api/OrderApiTest.php` (+4 tests):**
- `test_order_store_rejects_quantity_below_min_order`
- `test_order_store_accepts_quantity_equal_to_min_order`
- `test_order_store_persists_area_for_sized_item`

**`tests/Feature/OrderFormTest.php` (+4 tests):**
- `test_order_store_rejects_quantity_below_min_order`
- `test_order_store_accepts_quantity_equal_to_min_order`
- `test_order_store_persists_area_for_sized_item_in_cm2`
- `test_order_store_persists_area_in_m2`

**`tests/Unit/OrderTest.php` (+1 test):**
- `test_order_total_sums_item_totals`

**`tests/Unit/ProductTest.php` (+1 field):**
- Updated `test_product_has_correct_fillable_fields` — tambah `size_unit`

### 8.3 Test Summary

| Kategori | Sebelum | Sesudah | Tambahan |
|----------|---------|---------|----------|
| Feature Tests | 14 files | 16 files | +2 files |
| Unit Tests | 9 files | 9 files | — |
| Total Tests | ~150 | ~165 | +15 tests |

---

## 9. Migration Instructions

### 9.1 Jalankan Migrations

```bash
php artisan migrate
```

**Output yang Diharapkan:**
```
Migrating: 2026_08_01_000001_create_contact_messages_table
Migrated:  2026_08_01_000001_create_contact_messages_table (XX.XXms)
Migrating: 2026_08_01_100000_add_size_unit_to_products_and_size_to_order_items
Migrated:  2026_08_01_100000_add_size_unit_to_products_and_size_to_order_items (XX.XXms)
```

### 9.2 Update Existing Products (Optional)

Jika ingin mengatur `size_unit` untuk produk yang sudah ada:

```php
// Via Tinker
php artisan tinker

// Contoh: Set ukuran untuk produk tertentu
\App\Models\Product::where('name', 'Spanduk Banner')->update(['size_unit' => 'cm2']);
\App\Models\Product::where('name', 'Neon Box')->update(['size_unit' => 'm2']);
```

### 9.3 Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 10. Breaking Changes

### 10.1 Order Request Changes

**API `/api/v1/orders`** sekarang mendukung field baru (optional):

```diff
  {
      "items": [
          {
              "product_id": 1,
              "product_name": "Spanduk",
-             "quantity": 100
+             "quantity": 100,
+             "length_cm": 120,  // NEW (optional)
+             "width_cm": 80     // NEW (optional)
          }
      ]
  }
```

**Backward Compatible:** ✅ Ya — field baru bersifat optional.

### 10.2 Validation Changes

**Minimum Order Validation:**
- Request dengan `quantity` < `min_order` akan ditolak
- Error message: `"Jumlah order minimal X untuk Y"`

**Backward Compatible:** ⚠️ Partial — aplikasi yang mengirim quantity di bawah minimum akan mendapat error.

### 10.3 Order Items Response Changes

**Response `/api/v1/orders/{id}`** sekarang menyertakan field baru:

```diff
  {
      "items": [
          {
              "id": 1,
              "product_name": "Spanduk",
              "quantity": 100,
+             "length_cm": 120,
+             "width_cm": 80,
+             "area": 9600,
+             "size_unit": "cm2",
              "unit_price": 50000,
              "total_price": 5000000
          }
      ]
  }
```

**Backward Compatible:** ✅ Ya — field baru ditambahkan, tidak ada yang dihapus.

---

## 📝 Catatan

### Untuk Developer

1. **Jalankan migration** sebelum menggunakan fitur baru
2. **Update existing products** dengan `size_unit` jika diperlukan
3. **Perbarui tests** jika ada perubahan pada logic order

### Untuk Admin

1. **Menu baru** "Pesan Kontak" tersedia di sidebar admin
2. **Filter pesan** berdasarkan status (new/read/replied)
3. **Edit caption foto** langsung dari halaman edit album
4. **Produk baru** dapat diatur satuan perhitungan (cm²/m²)

### Untuk User

1. **Form order** sekarang menampilkan harga dan total
2. **Produk dengan ukuran** menampilkan input panjang × lebar
3. **Minimum order** ditampilkan dan divalidasi

---

> **Dokumen ini dibuat:** 3 Agustus 2026
> **Commit:** `7e3d5d5`
> **Author:** Aulia Louis
