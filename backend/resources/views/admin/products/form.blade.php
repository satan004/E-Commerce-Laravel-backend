@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'Create Product')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="panel stack">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label>
                Category
                <select name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Name
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </label>

            <label>
                Price
                <input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>
            </label>

            <label>
                Stock
                <input type="number" name="stock" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required>
            </label>
        </div>

        <label>
            Description
            <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
        </label>

        <div class="form-grid">
            <label>
                Product Image
                <input type="file" name="image" accept="image/*">
            </label>
            <label>
                Image URL
                <input type="url" name="image_url" value="{{ old('image_url', str_starts_with((string) $product->image_path, 'http') ? $product->image_path : '') }}">
            </label>
        </div>

        @if ($product->image_url)
            <img class="form-preview" src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @endif

        <label class="check-row">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
            Active product
        </label>

        <div class="form-actions">
            <a class="btn btn-muted" href="{{ route('admin.products.index') }}">Cancel</a>
            <button class="btn btn-primary" type="submit">{{ $product->exists ? 'Update' : 'Create' }}</button>
        </div>
    </form>
@endsection
