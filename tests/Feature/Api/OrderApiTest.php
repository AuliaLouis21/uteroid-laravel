<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_store_creates_order_with_items(): void
    {
        Mail::fake();
        $this->mock(WhatsAppService::class, fn($mock) => $mock->shouldReceive('sendOrderNotification')->once());

        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['product_category_id' => $category->id, 'unit_price' => 50000, 'min_order' => 1]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'items' => [
                ['product_id' => $product->id, 'product_name' => $product->name, 'quantity' => 2],
            ],
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'status', 'created_at'],
            ]);

        $this->assertDatabaseHas('orders', ['email' => 'jane@example.com', 'status' => 'pending']);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 2]);
    }

    public function test_order_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/orders', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'address', 'city', 'items']);
    }

    public function test_order_store_validates_items_minimum(): void
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'items' => [],
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['items']);
    }

    public function test_order_store_rejects_quantity_below_min_order(): void
    {
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['product_category_id' => $category->id, 'min_order' => 100]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'items' => [
                ['product_id' => $product->id, 'product_name' => $product->name, 'quantity' => 99],
            ],
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['items.0.quantity']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_store_accepts_quantity_equal_to_min_order(): void
    {
        Mail::fake();
        $this->mock(WhatsAppService::class, fn($mock) => $mock->shouldReceive('sendOrderNotification')->once());

        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['product_category_id' => $category->id, 'min_order' => 100]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'items' => [
                ['product_id' => $product->id, 'product_name' => $product->name, 'quantity' => 100],
            ],
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 100]);
    }

    public function test_order_store_persists_area_for_sized_item(): void
    {
        Mail::fake();
        $this->mock(WhatsAppService::class, fn($mock) => $mock->shouldReceive('sendOrderNotification')->once());

        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'product_category_id' => $category->id,
            'size' => '120cm x 80cm',
            'size_unit' => 'cm2',
            'unit_price' => 50000,
            'min_order' => 1,
        ]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 2,
                    'length_cm' => 120,
                    'width_cm' => 80,
                ],
            ],
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertCreated();

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'length_cm' => 120,
            'width_cm' => 80,
            'area' => 9600,
            'size_unit' => 'cm2',
        ]);
    }
}
