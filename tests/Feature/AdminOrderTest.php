<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createOrder(array $overrides = []): Order
    {
        return Order::factory()->create($overrides);
    }

    public function test_admin_order_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.orders.index'));

        $response->assertOk();
    }

    public function test_admin_order_show_returns_200(): void
    {
        $order = $this->createOrder();

        $response = $this->actingAs($this->user)->get(route('admin.orders.show', $order));

        $response->assertOk();
    }

    public function test_admin_order_update_updates_order(): void
    {
        $order = $this->createOrder(['status' => 'pending']);

        $data = [
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address,
            'city' => $order->city,
            'postal_code' => $order->postal_code,
            'message' => $order->message,
            'status' => 'completed',
        ];

        $response = $this->actingAs($this->user)->put(route('admin.orders.update', $order), $data);

        $response->assertRedirect(route('admin.orders.index'));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed']);
    }

    public function test_admin_order_destroy_deletes_order(): void
    {
        $order = $this->createOrder();

        $response = $this->actingAs($this->user)->delete(route('admin.orders.destroy', $order));

        $response->assertRedirect(route('admin.orders.index'));
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
