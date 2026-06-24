@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2>Category Management</h2>
            <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Create Category</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td class="actions">
                            <a class="btn btn-muted" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
@endsection
