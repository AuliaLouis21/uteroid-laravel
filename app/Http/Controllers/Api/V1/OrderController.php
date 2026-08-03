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
            'items.*.quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($request) {
                if (!preg_match('/items\.(\d+)\.quantity/', $attribute, $m)) {
                    return;
                }

                $productId = $request->input("items.{$m[1]}.product_id");
                if (! $productId) {
                    return;
                }

                $product = Product::find($productId);
                if ($product && $value < $product->min_order) {
                    $fail("Jumlah order minimal {$product->min_order} untuk {$product->name}.");
                }
            }],
            'items.*.length_cm' => 'nullable|numeric|min:0',
            'items.*.width_cm' => 'nullable|numeric|min:0',
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
                $sizeUnit = null;

                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $unitPrice = $product->unit_price;
                        $productName = $product->name;
                        $sizeUnit = $product->size_unit;
                    }
                }

                $lengthCm = isset($item['length_cm']) ? (float) $item['length_cm'] : 0;
                $widthCm = isset($item['width_cm']) ? (float) $item['width_cm'] : 0;
                $area = $this->calculateArea($lengthCm, $widthCm, $sizeUnit);

                $order->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $productName,
                    'quantity' => $item['quantity'],
                    'length_cm' => $lengthCm > 0 ? $lengthCm : null,
                    'width_cm' => $widthCm > 0 ? $widthCm : null,
                    'area' => $area,
                    'size_unit' => $sizeUnit,
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

    protected function calculateArea(float $lengthCm, float $widthCm, ?string $sizeUnit): ?float
    {
        if ($lengthCm <= 0 || $widthCm <= 0 || !in_array($sizeUnit, ['m2', 'cm2'], true)) {
            return null;
        }

        return $sizeUnit === 'm2'
            ? ($lengthCm * $widthCm) / 10000
            : $lengthCm * $widthCm;
    }
}
