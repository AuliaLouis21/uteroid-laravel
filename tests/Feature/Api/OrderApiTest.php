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
        $product = Product::factory()->create(['product_category_id' => $category->id, 'unit_price' => 50000]);

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
}
