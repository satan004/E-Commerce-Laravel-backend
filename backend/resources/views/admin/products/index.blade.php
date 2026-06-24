@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2>Product Management</h2>
            <a class="btn btn-primary" href="{{ route('admin.products.create') }}">Create Product</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="product-cell">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @endif
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><span class="badge">{{ $product->is_active ? 'active' : 'hidden' }}</span></td>
                        <td class="actions">
                            <a class="btn btn-muted" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
