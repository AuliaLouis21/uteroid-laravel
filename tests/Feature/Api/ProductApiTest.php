<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_returns_paginated_json(): void
    {
        $category = ProductCategory::factory()->create();
        Product::factory()->count(3)->create([
            'product_category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'unit_price', 'category', 'images'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_products_index_filters_by_category(): void
    {
        $category = ProductCategory::factory()->create(['slug' => 'banner']);
        Product::factory()->count(2)->create(['product_category_id' => $category->id]);
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/products?category=banner');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_products_index_filters_by_search(): void
    {
        Product::factory()->create(['name' => 'Spanduk Banner']);
        Product::factory()->create(['name' => 'Kartu Nama']);
        Product::factory()->create(['name' => 'Kalender']);

        $response = $this->getJson('/api/v1/products?search=Banner');

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_products_show_returns_single_product(): void
    {
        $product = Product::factory()->create(['slug' => 'spanduk-banner']);
        ProductImage::factory()->create(['product_id' => $product->id]);

        $response = $this->getJson('/api/v1/products/spanduk-banner');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'slug', 'unit_price', 'category', 'images'],
            ]);
    }

    public function test_products_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/v1/products/non-existent');

        $response->assertNotFound()
            ->assertJson(['message' => 'Product not found']);
    }

    public function test_products_categories_returns_json(): void
    {
        ProductCategory::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/products/categories');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug'],
                ],
            ]);
    }
}
