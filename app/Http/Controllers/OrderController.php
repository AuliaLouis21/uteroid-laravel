<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('orders.create', compact('products'));
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create(array_merge($request->validated(), [
            'status' => 'pending',
        ]));

        foreach ($request->items as $item) {
            $unitPrice = 0;
            if (!empty($item['product_id'])) {
                $product = Product::find($item['product_id']);
                $unitPrice = $product ? $product->unit_price : 0;
            }

            $order->items()->create([
                'product_id' => $item['product_id'] ?? null,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $item['quantity'],
            ]);
        }

        return redirect()->route('order.create')
            ->with('success', 'Pesanan berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
