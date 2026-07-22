@extends('layouts.admin')

@section('title', 'Order Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Order #{{ $order->id }}</h1>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Order Items</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No items.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Grand Total</td>
                                <td class="fw-bold">Rp {{ number_format($order->items->sum('total_price'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Customer Info</div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th style="width:120px;">Name</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $order->city }}</td>
                        </tr>
                        <tr>
                            <th>Postal Code</th>
                            <td>{{ $order->postal_code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>{{ $order->message ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Update Status</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
