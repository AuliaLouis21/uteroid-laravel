<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Mail\OrderReceivedMail;
use App\Mail\AdminOrderNotificationMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_create_page_returns_200(): void
    {
        $response = $this->get(route('order.create'));

        $response->assertOk();
    }

    public function test_order_create_page_displays_products(): void
    {
        $product = Product::factory()->create(['name' => 'Box Kardus A']);

        $response = $this->get(route('order.create'));

        $response->assertOk();
        $response->assertSee($product->name);
    }

    public function test_order_store_creates_order_with_items(): void
    {
        Mail::fake();
        $this->app->bind(\App\Services\WhatsAppService::class, function () {
            $mock = \Mockery::mock(\App\Services\WhatsAppService::class);
            $mock->shouldReceive('sendOrderNotification')->once();
            return $mock;
        });

        $product = Product::factory()->create(['unit_price' => 10000, 'min_order' => 50]);

        $data = [
            'name' => 'John Buyer',
            'email' => 'john@buyer.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Malang',
            'postal_code' => '65141',
            'message' => 'Urgent order',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 100,
                ],
            ],
        ];

        $response = $this->post(route('order.store'), $data);

        $response->assertRedirect(route('order.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'name' => 'John Buyer',
            'email' => 'john@buyer.com',
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 100,
            'unit_price' => 10000,
            'total_price' => 1000000,
        ]);
    }

    public function test_order_store_sends_emails(): void
    {
        Mail::fake();
        $this->app->bind(\App\Services\WhatsAppService::class, function () {
            $mock = \Mockery::mock(\App\Services\WhatsAppService::class);
            $mock->shouldReceive('sendOrderNotification')->once();
            return $mock;
        });

        $product = Product::factory()->create(['min_order' => 5]);

        $data = [
            'name' => 'Email Test',
            'email' => 'email@test.com',
            'phone' => '08123456789',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 10,
                ],
            ],
        ];

        $this->post(route('order.store'), $data);

        Mail::assertQueued(OrderReceivedMail::class, function ($mail) {
            return $mail->hasTo('email@test.com');
        });
        Mail::assertQueued(AdminOrderNotificationMail::class);
    }

    public function test_order_store_validates_required_fields(): void
    {
        $response = $this->post(route('order.store'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'items']);
    }

    public function test_order_store_validates_items_minimum(): void
    {
        $response = $this->post(route('order.store'), [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '08123456789',
            'items' => [],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['items']);
    }

    public function test_order_store_validates_item_quantity(): void
    {
        $response = $this->post(route('order.store'), [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '08123456789',
            'items' => [
                [
                    'product_name' => 'Test Product',
                    'quantity' => 0,
                ],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['items.0.quantity']);
    }

    public function test_order_store_rejects_quantity_below_min_order(): void
    {
        $product = Product::factory()->create(['min_order' => 100]);

        $response = $this->post(route('order.store'), [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '08123456789',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 99,
                ],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['items.0.quantity']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_store_accepts_quantity_equal_to_min_order(): void
    {
        Mail::fake();
        $this->app->bind(\App\Services\WhatsAppService::class, function () {
            $mock = \Mockery::mock(\App\Services\WhatsAppService::class);
            $mock->shouldReceive('sendOrderNotification')->once();
            return $mock;
        });

        $product = Product::factory()->create(['min_order' => 100, 'unit_price' => 10000]);

        $response = $this->post(route('order.store'), [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '08123456789',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 100,
                ],
            ],
        ]);

        $response->assertRedirect(route('order.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 100,
        ]);
    }

    public function test_order_store_persists_area_for_sized_item_in_cm2(): void
    {
        Mail::fake();
        $this->app->bind(\App\Services\WhatsAppService::class, function () {
            $mock = \Mockery::mock(\App\Services\WhatsAppService::class);
            $mock->shouldReceive('sendOrderNotification')->once();
            return $mock;
        });

        $product = Product::factory()->create([
            'size' => '120cm x 80cm',
            'size_unit' => 'cm2',
            'unit_price' => 10000,
            'min_order' => 1,
        ]);

        $data = [
            'name' => 'Sized Buyer',
            'email' => 'sized@buyer.com',
            'phone' => '08123456789',
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

        $this->post(route('order.store'), $data);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'length_cm' => 120,
            'width_cm' => 80,
            'area' => 9600,
            'size_unit' => 'cm2',
        ]);
    }

    public function test_order_store_persists_area_in_m2(): void
    {
        Mail::fake();
        $this->app->bind(\App\Services\WhatsAppService::class, function () {
            $mock = \Mockery::mock(\App\Services\WhatsAppService::class);
            $mock->shouldReceive('sendOrderNotification')->once();
            return $mock;
        });

        $product = Product::factory()->create([
            'size' => '2m x 1m',
            'size_unit' => 'm2',
            'unit_price' => 50000,
            'min_order' => 1,
        ]);

        $data = [
            'name' => 'M2 Buyer',
            'email' => 'm2@buyer.com',
            'phone' => '08123456789',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 1,
                    'length_cm' => 200,
                    'width_cm' => 100,
                ],
            ],
        ];

        $this->post(route('order.store'), $data);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'length_cm' => 200,
            'width_cm' => 100,
            'area' => 2,
            'size_unit' => 'm2',
        ]);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
