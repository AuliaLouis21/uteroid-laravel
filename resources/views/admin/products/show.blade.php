@extends('layouts.admin')

@section('title', 'Product Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Detail</div>
                <div class="card-body">
                    <table class="table">
                        <tr><th>ID</th><td>{{ $product->id }}</td></tr>
                        <tr><th>Name</th><td>{{ $product->name }}</td></tr>
                        <tr><th>Slug</th><td>{{ $product->slug }}</td></tr>
                        <tr><th>Category</th><td>{{ $product->category->name ?? '-' }}</td></tr>
                        <tr><th>Price</th><td>Rp {{ number_format($product->unit_price, 0, ',', '.') }}</td></tr>
                        <tr><th>Created</th><td>{{ $product->created_at->format('d M Y H:i') }}</td></tr>
                        <tr><th>Updated</th><td>{{ $product->updated_at->format('d M Y H:i') }}</td></tr>
                    </table>
                </div>
            </div>

            @if($product->description)
                <div class="card mb-4">
                    <div class="card-header">Description</div>
                    <div class="card-body">{!! nl2br(e($product->description)) !!}</div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Image</div>
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @else
                        <p class="text-muted">No image.</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning w-100 mb-2">Edit</a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger w-100">Delete</button>
            </form>
        </div>
    </div>
@endsection
