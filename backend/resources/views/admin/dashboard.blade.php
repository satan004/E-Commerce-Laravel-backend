@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="stats-grid">
        <article class="stat-card">
            <span>Categories</span>
            <strong>{{ $stats['categories'] }}</strong>
        </article>
        <article class="stat-card">
            <span>Products</span>
            <strong>{{ $stats['products'] }}</strong>
        </article>
        <article class="stat-card">
            <span>Orders</span>
            <strong>{{ $stats['orders'] }}</strong>
        </article>
        <article class="stat-card">
            <span>Customers</span>
            <strong>{{ $stats['users'] }}</strong>
        </article>
        <article class="stat-card">
            <span>Completed revenue</span>
            <strong>${{ number_format($stats['revenue'], 2) }}</strong>
        </article>
    </section>

    <section class="two-column">
        <div class="panel">
            <div class="panel-header">
                <h2>Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}">View all</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td><span class="badge">{{ $order->status }}</span></td>
                            <td>${{ number_format($order->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Low Stock</h2>
                <a href="{{ route('admin.products.index') }}">Manage</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Inventory looks healthy.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
