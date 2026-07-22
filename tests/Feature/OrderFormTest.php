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

        $product = Product::factory()->create(['unit_price' => 10000]);

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

        $product = Product::factory()->create();

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

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
