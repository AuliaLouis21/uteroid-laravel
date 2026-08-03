<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_has_many_items(): void
    {
        $order = Order::factory()->create();

        OrderItem::factory()->count(3)->create(['order_id' => $order->id]);

        $this->assertCount(3, $order->items);
        $this->assertInstanceOf(OrderItem::class, $order->items->first());
    }

    public function test_order_has_correct_fillable_fields(): void
    {
        $order = new Order;

        $this->assertEquals([
            'name',
            'email',
            'phone',
            'address',
            'city',
            'postal_code',
            'message',
            'status',
        ], $order->getFillable());
    }

    public function test_order_item_belongs_to_order(): void
    {
        $order = Order::factory()->create();
        $orderItem = OrderItem::factory()->create(['order_id' => $order->id]);

        $this->assertInstanceOf(Order::class, $orderItem->order);
        $this->assertEquals($order->id, $orderItem->order->id);
    }

    public function test_order_total_sums_item_totals(): void
    {
        $order = Order::factory()->create();

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'unit_price' => 10000,
            'total_price' => 20000,
        ]);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        $this->assertEquals(35000, $order->total);
    }
}
