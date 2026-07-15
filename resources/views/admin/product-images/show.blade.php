@extends('layouts.admin')

@section('title', 'Product Image Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Product Image Detail</h1>
        <div>
            <a href="{{ route('admin.product-images.edit', $productImage) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.product-images.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Product</th>
                    <td>{{ $productImage->product->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Filename</th>
                    <td>{{ $productImage->filename }}</td>
                </tr>
                <tr>
                    <th>Thumbnail</th>
                    <td>
                        @if($productImage->filename)
                            <img src="{{ asset('storage/' . $productImage->filename) }}" alt="Product Image" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Is Thumbnail</th>
                    <td>{{ $productImage->is_thumbnail ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $productImage->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
