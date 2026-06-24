@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <section class="two-column">
        <div class="panel stack">
            <div class="panel-header">
                <h2>Order Details</h2>
                <span class="badge">{{ $order->status }}</span>
            </div>
            <p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
            <p><strong>Shipping:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Payment:</strong> {{ str_replace('_', ' ', $order->payment_method) }}</p>
            @if ($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif

            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline-form">
                @csrf
                @method('PATCH')
                <select name="status">
                    @foreach (\App\Models\Order::STATUSES as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Update Status</button>
            </form>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Items</h2>
                <strong>${{ number_format($order->total, 2) }}</strong>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->unit_price, 2) }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
