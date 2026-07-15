<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->string('slug')->unique();

        $table->string('size')->nullable();
        $table->string('thickness')->nullable();

        $table->integer('min_order')->default(1);
        $table->decimal('unit_price',15,2)->default(0);

        $table->longText('description')->nullable();

        $table->foreignId('product_category_id')->nullable();
        $table->foreignId('product_type_id')->nullable();

        $table->boolean('is_promo')->default(false);

        $table->date('published_at')->nullable();
        $table->time('published_time')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
