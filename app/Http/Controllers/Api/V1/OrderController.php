<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceivedMail;
use App\Mail\AdminOrderNotificationMail;

class OrderController extends Controller
{
    public function store(Request $request, WhatsAppService $whatsapp): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'message' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'] ?? null,
                'message' => $validated['message'] ?? null,
                'status' => 'pending',
            ]);

            foreach ($validated['items'] as $item) {
                $unitPrice = 0;
                $productName = $item['product_name'];

                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $unitPrice = $product->unit_price;
                        $productName = $product->name;
                    }
                }

                $order->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $productName,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'total_price' => $unitPrice * $item['quantity'],
                ]);
            }

            return $order;
        });

        // Queue emails async
        Mail::to($order->email)->queue(new OrderReceivedMail($order));
        Mail::to(config('mail.from.address'))->queue(new AdminOrderNotificationMail($order));

        // WhatsApp notification
        $whatsapp->sendOrderNotification($order);

        return response()->json([
            'message' => 'Order submitted successfully.',
            'data' => [
                'id' => $order->id,
                'status' => $order->status,
                'created_at' => $order->created_at->toIso8601String(),
            ],
        ], 201);
    }
}
