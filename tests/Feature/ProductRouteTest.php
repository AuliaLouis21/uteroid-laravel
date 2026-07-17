<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_index_returns_200(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertOk();
    }

    public function test_product_show_returns_200(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'size' => '10x20',
            'unit_price' => 50000,
        ]);

        $response = $this->get(route('products.show', $product->slug));

        $response->assertOk();
    }

    public function test_product_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->get(route('products.show', 'invalid-slug-yang-tidak-ada'));

        $response->assertNotFound();
    }

    public function test_product_category_returns_200(): void
    {
        $category = ProductCategory::factory()->create();
        Product::create([
            'name' => 'Category Product',
            'slug' => 'category-product',
            'product_category_id' => $category->id,
            'size' => '10x20',
            'unit_price' => 50000,
        ]);

        $response = $this->get(route('products.category', $category->slug));

        $response->assertOk();
    }
}
