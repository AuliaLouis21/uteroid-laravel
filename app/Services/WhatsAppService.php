<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiToken;
    protected string $adminPhone;

    public function __construct()
    {
        $this->apiUrl = config('whatsapp.api_url') ?: \App\Models\Setting::where('key', 'whatsapp_api_url')->value('value') ?? '';
        $this->apiToken = config('whatsapp.api_token') ?: \App\Models\Setting::where('key', 'whatsapp_api_token')->value('value') ?? '';
        $this->adminPhone = config('whatsapp.admin_phone') ?: \App\Models\Setting::where('key', 'site_whatsapp')->value('value') ?? '6281999900900';
    }

    public function sendOrderNotification(Order $order): bool
    {
        $message = $this->buildOrderMessage($order);

        if (empty($this->apiUrl) || empty($this->apiToken)) {
            Log::info('WhatsApp API not configured. Order notification not sent.', [
                'order_id' => $order->id,
                'message' => $message,
            ]);
            return false;
        }

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(10)
                ->post($this->apiUrl, [
                    'phone' => $this->adminPhone,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('WhatsApp API returned error', [
                'order_id' => $order->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp API request failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function buildOrderMessage(Order $order): string
    {
        $items = $order->items->map(function ($item) {
            return "  - {$item->product_name} x{$item->quantity}";
        })->implode("\n");

        $total = number_format($order->items->sum('total_price'), 0, ',', '.');

        $city = $order->city ?? '-';
        $address = $order->address ?? '-';
        $phone = $order->phone ?? '-';

        return "*Pesanan Baru #{$order->id}*\n\n" .
            "Nama: {$order->name}\n" .
            "Email: {$order->email}\n" .
            "Telepon: {$phone}\n" .
            "Kota: {$city}\n" .
            "Alamat: {$address}\n\n" .
            "*Produk:*\n{$items}\n\n" .
            "*Total: Rp. {$total}*";
    }

    public function getAdminPhoneLink(string $text = ''): string
    {
        $phone = str_replace([' ', '-', '+'], '', $this->adminPhone);
        $encoded = $text ? '?' . http_build_query(['text' => $text]) : '';
        return "https://wa.me/{$phone}{$encoded}";
    }
}
