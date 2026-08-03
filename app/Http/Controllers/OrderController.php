<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use App\Mail\OrderReceivedMail;
use App\Mail\AdminOrderNotificationMail;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $preselectedProduct = null;

        if ($request->has('product_id')) {
            $preselectedProduct = Product::find($request->product_id);
        }

        return view('orders.create', compact('products', 'preselectedProduct'));
    }

    public function store(OrderRequest $request, WhatsAppService $whatsapp)
    {
        $order = DB::transaction(function () use ($request) {
            $order = Order::create(array_merge($request->validated(), [
                'status' => 'pending',
            ]));

            foreach ($request->items as $item) {
                $unitPrice = 0;
                $productName = $item['product_name'];
                $sizeUnit = null;

                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $unitPrice = $product->unit_price;
                        $productName = $product->name;
                        $sizeUnit = $product->size_unit;
                    }
                }

                // Area-based pricing
                $area = isset($item['area']) ? (float) $item['area'] : 0;
                $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $unitTotal = $unitPrice * $area;
                $totalPrice = $unitTotal * $quantity;

                $order->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $productName,
                    'quantity' => $quantity,
                    'area' => $area > 0 ? $area : null,
                    'size_unit' => $sizeUnit,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ]);
            }

            return $order;
        });

        Mail::to($order->email)->queue(new OrderReceivedMail($order));
        Mail::to(config('mail.from.address'))->queue(new AdminOrderNotificationMail($order));

        $whatsapp->sendOrderNotification($order);

        return redirect()->route('order.create')
            ->with('success', 'Pesanan berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
