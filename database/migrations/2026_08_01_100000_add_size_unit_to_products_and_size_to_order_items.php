<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('size_unit')->nullable()->after('size');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('length_cm', 12, 2)->nullable()->after('quantity');
            $table->decimal('width_cm', 12, 2)->nullable()->after('length_cm');
            $table->decimal('area', 15, 4)->nullable()->after('width_cm');
            $table->string('size_unit')->nullable()->after('area');
        });

        $this->backfillSizeUnit();
    }

    /**
     * Infer a default size unit from the product's size text so existing
     * products get a sensible calculation unit that admins can adjust.
     */
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('size_unit');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['length_cm', 'width_cm', 'area', 'size_unit']);
        });
    }
};
