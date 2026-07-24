<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #ce181e; color: #fff; padding: 15px 20px; border-radius: 4px 4px 0 0; }
        .body { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-top: none; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #eee; }
        .total { font-weight: bold; font-size: 16px; }
        .footer { font-size: 12px; color: #999; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Pesanan Anda Diterima</h2>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $order->name }}</strong>,</p>
            <p>Terima kasih! Pesanan Anda dengan nomor <strong>#{{ $order->id }}</strong> telah kami terima.</p>

            <h3>Detail Pesanan:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total" style="margin-top:15px;">Grand Total: Rp {{ number_format($order->items->sum('total_price'), 0, ',', '.') }}</p>

            <hr style="border:none;border-top:1px solid #ddd;">
            <p><strong>Nama:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Telepon:</strong> {{ $order->phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</p>

            <p style="margin-top:20px;">Kami akan segera menghubungi Anda untuk konfirmasi pesanan.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Utero Group. Email ini dikirim otomatis dari sistem pemesanan website.
        </div>
    </div>
</body>
</html>
