<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportLegacy extends Command
{
    protected $signature = 'import:legacy
        {--truncate : Truncate all target tables before importing}';

    protected $description = 'Import data from legacy uteroid_cms database into new Laravel schema';

    private $legacy;
    private $counts = [];

    public function handle(): int
    {
        $this->legacy = DB::connection('legacy');

        try {
            $this->legacy->getPdo();
        } catch (\Exception $e) {
            $this->error('Cannot connect to legacy database. Check LEGACY_DB_* in .env');
            return 1;
        }

        $this->info('Connected to: ' . $this->legacy->getDatabaseName());
        $this->newLine();

        if ($this->option('truncate')) {
            $this->warn('Truncating target tables...');
            $this->truncateTargetTables();
            $this->newLine();
        }

        DB::transaction(function () {
            $this->importUsers();
            $this->importProductCategories();
            $this->importProductTypes();
            $this->importProducts();
            $this->importProductImages();
            $this->importPosts();
            $this->importPages();
            $this->importAlbums();
            $this->importAlbumPhotos();
            $this->importAlbumVideos();
            $this->importAlbumAudio();
            $this->importTestimonials();
            $this->importAdvertisements();
            $this->importSettings();
            $this->importOrders();
            $this->importOrderItems();
        });

        $this->newLine();
        $this->info('=== IMPORT COMPLETE ===');
        $this->newLine();

        foreach ($this->counts as $table => $count) {
            $this->line("  {$table}: {$count} rows");
        }

        $total = array_sum($this->counts);
        $this->newLine();
        $this->info("Total: {$total} rows imported");

        return 0;
    }

    private function truncateTargetTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ([
            'order_items', 'orders', 'settings', 'advertisements', 'testimonials',
            'album_audios', 'album_videos', 'album_photos', 'albums',
            'product_images', 'products', 'product_types', 'product_categories',
            'posts', 'pages', 'users',
        ] as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function ts(?string $date, ?string $time = '00:00:00'): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse(($date ?: date('Y-m-d')) . ' ' . ($time ?: '00:00:00'));
    }

    // ─── 1. USERS ───────────────────────────────────────────

    private function importUsers(): void
    {
        $this->info('[1/16] Users');

        // admin table: user, pass, email
        $adminRows = $this->legacy->table('admin')->get();
        foreach ($adminRows as $row) {
            DB::table('users')->insertOrIgnore([
                'name' => $row->user,
                'email' => $row->email ?: $row->user . '@legacy.local',
                'password' => bcrypt($row->pass),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // member table: id, uname, passwd, email
        $memberRows = $this->legacy->table('member')->get();
        foreach ($memberRows as $row) {
            DB::table('users')->insertOrIgnore([
                'name' => $row->uname,
                'email' => $row->email ?: $row->uname . '@legacy.local',
                'password' => bcrypt($row->passwd ?: Str::random(20)),
                'role' => 'editor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->counts['users'] = $adminRows->count() + $memberRows->count();
        $this->line("  -> {$adminRows->count()} admin + {$memberRows->count()} members");
    }

    // ─── 2. PRODUCT CATEGORIES ──────────────────────────────

    private function importProductCategories(): void
    {
        $this->info('[2/16] Product Categories');

        $rows = $this->legacy->table('catproduk')->get();
        foreach ($rows as $row) {
            DB::table('product_categories')->insertOrIgnore([
                'name' => $row->nama,
                'slug' => $row->slug ?: Str::slug($row->nama),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->counts['product_categories'] = $rows->count();
        $this->line("  -> {$rows->count()} categories");
    }

    // ─── 3. PRODUCT TYPES ───────────────────────────────────

    private function importProductTypes(): void
    {
        $this->info('[3/16] Product Types');

        $rows = $this->legacy->table('jnsproduk')->get();
        foreach ($rows as $row) {
            DB::table('product_types')->insertOrIgnore([
                'name' => $row->nama,
                'slug' => $row->slug ?: Str::slug($row->nama),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->counts['product_types'] = $rows->count();
        $this->line("  -> {$rows->count()} types");
    }

    // ─── 4. PRODUCTS ────────────────────────────────────────

    private function importProducts(): void
    {
        $this->info('[4/16] Products');

        // Build name→id maps for categories and types
        $catMap = [];
        foreach (DB::table('product_categories')->get() as $r) {
            $catMap[$r->name] = $r->id;
        }
        $typeMap = [];
        foreach (DB::table('product_types')->get() as $r) {
            $typeMap[$r->name] = $r->id;
        }

        // Build legacy cat ID → name, jns ID → name
        $legacyCatNames = [];
        foreach ($this->legacy->table('catproduk')->get() as $r) {
            $legacyCatNames[$r->id] = $r->nama;
        }
        $legacyTypeNames = [];
        foreach ($this->legacy->table('jnsproduk')->get() as $r) {
            $legacyTypeNames[$r->id] = $r->nama;
        }

        $rows = $this->legacy->table('produk')->get();
        foreach ($rows as $row) {
            $catName = $legacyCatNames[$row->cat] ?? null;
            $typeName = $legacyTypeNames[$row->jns] ?? null;

            DB::table('products')->insertOrIgnore([
                'name' => $row->nama,
                'slug' => $row->slug ?: Str::slug($row->nama),
                'size' => $row->ukuran ?: null,
                'thickness' => $row->ketebalan ?: null,
                'min_order' => (int) $row->minorder,
                'unit_price' => (float) $row->hargasatuan,
                'description' => $row->descript ?: null,
                'product_category_id' => $catName ? ($catMap[$catName] ?? null) : null,
                'product_type_id' => $typeName ? ($typeMap[$typeName] ?? null) : null,
                'is_promo' => $row->promo == '1',
                'published_at' => $row->tgl,
                'published_time' => $row->jam,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['products'] = $rows->count();
        $this->line("  -> {$rows->count()} products");
    }

    // ─── 5. PRODUCT IMAGES ──────────────────────────────────

    private function importProductImages(): void
    {
        $this->info('[5/16] Product Images');

        // Build legacy produk id → new product id (via slug)
        $prodMap = [];
        foreach ($this->legacy->table('produk')->get() as $r) {
            $new = DB::table('products')->where('slug', $r->slug)->first();
            if ($new) {
                $prodMap[$r->id] = $new->id;
            }
        }

        $rows = $this->legacy->table('image')->get();
        foreach ($rows as $row) {
            $productId = $prodMap[$row->produkid] ?? null;
            if ($productId) {
                DB::table('product_images')->insertOrIgnore([
                    'product_id' => $productId,
                    'filename' => $row->img,
                    'is_thumbnail' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->counts['product_images'] = $rows->count();
        $this->line("  -> {$rows->count()} images");
    }

    // ─── 6. POSTS (NEWS) ────────────────────────────────────

    private function importPosts(): void
    {
        $this->info('[6/16] Posts');

        $rows = $this->legacy->table('posts')->get();
        foreach ($rows as $row) {
            DB::table('posts')->insertOrIgnore([
                'title' => $row->judul,
                'slug' => $row->slug ?: Str::slug($row->judul),
                'excerpt' => Str::limit(strip_tags($row->isi ?? ''), 200),
                'content' => $row->isi,
                'image' => $row->img ?: null,
                'category_id' => null,
                'published_at' => $row->tgl,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['posts'] = $rows->count();
        $this->line("  -> {$rows->count()} posts");
    }

    // ─── 7. PAGES ───────────────────────────────────────────

    private function importPages(): void
    {
        $this->info('[7/16] Pages');

        $rows = $this->legacy->table('page')->get();
        foreach ($rows as $row) {
            DB::table('pages')->insertOrIgnore([
                'title' => $row->judul,
                'slug' => $row->slug ?: Str::slug($row->judul),
                'content' => $row->isi,
                'image' => null,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['pages'] = $rows->count();
        $this->line("  -> {$rows->count()} pages");
    }

    // ─── 8. ALBUMS ──────────────────────────────────────────

    private function importAlbums(): void
    {
        $this->info('[8/16] Albums');

        $rows = $this->legacy->table('albumpic')->get();
        foreach ($rows as $row) {
            DB::table('albums')->insertOrIgnore([
                'name' => $row->nama,
                'slug' => $row->slug ?: Str::slug($row->nama),
                'description' => $row->descript ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->counts['albums'] = $rows->count();
        $this->line("  -> {$rows->count()} albums");
    }

    // ─── 9. ALBUM PHOTOS ────────────────────────────────────

    private function importAlbumPhotos(): void
    {
        $this->info('[9/16] Album Photos');

        // pictgal.cat → albumpic.id → albums.id
        $albumMap = [];
        foreach ($this->legacy->table('albumpic')->get() as $r) {
            $new = DB::table('albums')->where('slug', $r->slug)->first();
            if ($new) {
                $albumMap[$r->id] = $new->id;
            }
        }

        $rows = $this->legacy->table('pictgal')->get();
        foreach ($rows as $row) {
            $albumId = $albumMap[$row->cat] ?? null;
            if ($albumId) {
                DB::table('album_photos')->insertOrIgnore([
                    'album_id' => $albumId,
                    'filename' => $row->img,
                    'caption' => $row->judul ?: null,
                    'created_at' => $this->ts($row->tgl, $row->jam),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->counts['album_photos'] = $rows->count();
        $this->line("  -> {$rows->count()} photos");
    }

    // ─── 10. ALBUM VIDEOS ───────────────────────────────────

    private function importAlbumVideos(): void
    {
        $this->info('[10/16] Album Videos');

        // vidgal has no album FK — create default album if needed
        $defaultAlbum = DB::table('albums')->where('slug', 'video-gallery')->first();
        if (!$defaultAlbum) {
            $albumId = DB::table('albums')->insertGetId([
                'name' => 'Video Gallery',
                'slug' => 'video-gallery',
                'description' => 'Default album for imported videos',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $albumId = $defaultAlbum->id;
        }

        $rows = $this->legacy->table('vidgal')->get();
        foreach ($rows as $row) {
            DB::table('album_videos')->insertOrIgnore([
                'album_id' => $albumId,
                'title' => $row->judul,
                'slug' => $row->slug ?: Str::slug($row->judul),
                'url' => $row->vid,
                'description' => $row->ket ?: null,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['album_videos'] = $rows->count();
        $this->line("  -> {$rows->count()} videos");
    }

    // ─── 11. ALBUM AUDIO ────────────────────────────────────

    private function importAlbumAudio(): void
    {
        $this->info('[11/16] Album Audio');

        // audgal has no album FK — create default album if needed
        $defaultAlbum = DB::table('albums')->where('slug', 'audio-gallery')->first();
        if (!$defaultAlbum) {
            $albumId = DB::table('albums')->insertGetId([
                'name' => 'Audio Gallery',
                'slug' => 'audio-gallery',
                'description' => 'Default album for imported audio',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $albumId = $defaultAlbum->id;
        }

        $rows = $this->legacy->table('audgal')->get();
        foreach ($rows as $row) {
            DB::table('album_audio')->insertOrIgnore([
                'album_id' => $albumId,
                'title' => $row->judul,
                'slug' => $row->slug ?: Str::slug($row->judul),
                'filename' => $row->aud,
                'description' => $row->ket ?: null,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['album_audio'] = $rows->count();
        $this->line("  -> {$rows->count()} audio tracks");
    }

    // ─── 12. TESTIMONIALS ───────────────────────────────────

    private function importTestimonials(): void
    {
        $this->info('[12/16] Testimonials');

        $rows = $this->legacy->table('testi')->get();
        foreach ($rows as $row) {
            DB::table('testimonials')->insertOrIgnore([
                'name' => $row->pengirim,
                'email' => $row->mail ?: null,
                'company' => $row->prsh ?: null,
                'content' => $row->testi,
                'status' => $row->approve == '1' ? 'approved' : 'pending',
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['testimonials'] = $rows->count();
        $this->line("  -> {$rows->count()} testimonials");
    }

    // ─── 13. ADVERTISEMENTS ─────────────────────────────────

    private function importAdvertisements(): void
    {
        $this->info('[13/16] Advertisements');

        $rows = $this->legacy->table('ads')->get();
        foreach ($rows as $row) {
            DB::table('advertisements')->insertOrIgnore([
                'title' => $row->judul,
                'content' => $row->info ?: null,
                'slug' => $row->slug ?: Str::slug($row->judul),
                'image' => $row->img ?: null,
                'link' => null,
                'is_active' => true,
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
        }
        $this->counts['advertisements'] = $rows->count();
        $this->line("  -> {$rows->count()} ads");
    }

    // ─── 14. SETTINGS ───────────────────────────────────────

    private function importSettings(): void
    {
        $this->info('[14/16] Settings');

        $settings = [
            ['key' => 'emailorder', 'value' => $this->legacy->table('setting')->value('emailorder')],
            ['key' => 'company_name', 'value' => $this->legacy->table('logminfo')->value('nama')],
            ['key' => 'company_email', 'value' => $this->legacy->table('logminfo')->value('email')],
        ];

        foreach ($settings as $s) {
            if ($s['value']) {
                DB::table('settings')->insertOrIgnore([
                    'key' => $s['key'],
                    'value' => $s['value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->counts['settings'] = count(array_filter($settings, fn($s) => $s['value']));
        $this->line("  -> {$this->counts['settings']} settings");
    }

    // ─── 15. ORDERS ─────────────────────────────────────────

    private function importOrders(): void
    {
        $this->info('[15/16] Orders');

        // We need to track legacy id → new id for order_items
        $this->orderMap = [];

        $rows = $this->legacy->table('orderuser')->get();
        foreach ($rows as $row) {
            $newId = DB::table('orders')->insertGetId([
                'name' => $row->nama,
                'email' => $row->email ?: null,
                'phone' => $row->notelp,
                'address' => $row->alamat ?: null,
                'city' => null,
                'postal_code' => $row->kodepos ?: null,
                'message' => $row->pesan ?: null,
                'status' => 'completed',
                'created_at' => $this->ts($row->tgl, $row->jam),
                'updated_at' => now(),
            ]);
            $this->orderMap[$row->id] = $newId;
        }
        $this->counts['orders'] = $rows->count();
        $this->line("  -> {$rows->count()} orders");
    }

    private array $orderMap = [];

    // ─── 16. ORDER ITEMS ────────────────────────────────────

    private function importOrderItems(): void
    {
        $this->info('[16/16] Order Items');

        // Build legacy produk id → new product id (via slug)
        $prodMap = [];
        foreach ($this->legacy->table('produk')->get() as $r) {
            $new = DB::table('products')->where('slug', $r->slug)->first();
            if ($new) {
                $prodMap[$r->id] = $new->id;
            }
        }

        $rows = $this->legacy->table('ordernya')->get();
        foreach ($rows as $row) {
            $orderId = $this->orderMap[$row->userid] ?? null;
            $productId = $prodMap[$row->produkid] ?? null;

            if ($orderId) {
                DB::table('order_items')->insertOrIgnore([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'product_name' => $row->produk,
                    'quantity' => (int) $row->jumlahorder,
                    'unit_price' => (float) $row->harga,
                    'total_price' => (float) $row->total,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->counts['order_items'] = $rows->count();
        $this->line("  -> {$rows->count()} items");
    }
}
