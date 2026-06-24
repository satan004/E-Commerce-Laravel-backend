@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Category' : 'Create Category')

@section('content')
    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="panel stack">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <label>
            Name
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </label>

        <label>
            Description
            <textarea name="description" rows="5">{{ old('description', $category->description) }}</textarea>
        </label>

        <div class="form-actions">
            <a class="btn btn-muted" href="{{ route('admin.categories.index') }}">Cancel</a>
            <button class="btn btn-primary" type="submit">{{ $category->exists ? 'Update' : 'Create' }}</button>
        </div>
    </form>
@endsection
