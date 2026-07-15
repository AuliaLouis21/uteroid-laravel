@extends('layouts.admin')

@section('title', 'Product Category Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $productCategory->name }}</h1>
        <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr><th>ID</th><td>{{ $productCategory->id }}</td></tr>
                <tr><th>Name</th><td>{{ $productCategory->name }}</td></tr>
                <tr><th>Slug</th><td>{{ $productCategory->slug }}</td></tr>
                <tr><th>Products</th><td>{{ $productCategory->products()->count() }}</td></tr>
                <tr><th>Created</th><td>{{ $productCategory->created_at->format('d M Y H:i') }}</td></tr>
                <tr><th>Updated</th><td>{{ $productCategory->updated_at->format('d M Y H:i') }}</td></tr>
            </table>

            <a href="{{ route('admin.product-categories.edit', $productCategory) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.product-categories.destroy', $productCategory) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
@endsection
