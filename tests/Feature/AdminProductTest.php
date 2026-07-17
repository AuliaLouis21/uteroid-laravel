<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createProduct(array $overrides = []): Product
    {
        $category = ProductCategory::factory()->create();

        return Product::create(array_merge([
            'name' => fake()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'size' => '10x10',
            'thickness' => '1mm',
            'min_order' => 100,
            'unit_price' => 50000,
            'description' => fake()->sentence(),
            'product_category_id' => $category->id,
            'is_promo' => false,
        ], $overrides));
    }

    public function test_admin_product_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.products.index'));

        $response->assertOk();
    }

    public function test_admin_product_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.products.create'));

        $response->assertOk();
    }

    public function test_admin_product_store_creates_product(): void
    {
        $category = ProductCategory::factory()->create();

        $data = [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'product_category_id' => $category->id,
            'unit_price' => 50000,
            'size' => '10x10',
            'thickness' => '1mm',
            'min_order' => 100,
            'description' => 'A test product description.',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.products.store'), $data);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_admin_product_show_returns_200(): void
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->user)->get(route('admin.products.show', $product));

        $response->assertOk();
    }

    public function test_admin_product_edit_returns_200(): void
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->user)->get(route('admin.products.edit', $product));

        $response->assertOk();
    }

    public function test_admin_product_update_updates_product(): void
    {
        $product = $this->createProduct(['name' => 'Old Name']);

        $data = [
            'name' => 'Updated Product Name',
            'product_category_id' => $product->product_category_id,
            'slug' => $product->slug,
            'unit_price' => 75000,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.products.update', $product), $data);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product Name']);
    }

    public function test_admin_product_destroy_deletes_product(): void
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->user)->delete(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
