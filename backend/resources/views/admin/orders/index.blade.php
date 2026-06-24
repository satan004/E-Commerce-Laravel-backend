@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2>Order Management</h2>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td><span class="badge">{{ $order->status }}</span></td>
                        <td class="actions">
                            <a class="btn btn-muted" href="{{ route('admin.orders.show', $order) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
@endsection
