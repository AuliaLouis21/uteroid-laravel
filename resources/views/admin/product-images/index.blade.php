@extends('layouts.admin')

@section('title', 'Product Images')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Product Images</h1>
        <a href="{{ route('admin.product-images.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Thumbnail</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($images as $image)
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td>
                                @if($image->filename)
                                    <img src="{{ asset('storage/' . $image->filename) }}" alt="{{ $image->product->name ?? '' }}" width="60" height="60" style="object-fit:cover; border-radius:4px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $image->product->name ?? '-' }}</td>
                            <td>
                                @if($image->is_thumbnail)
                                    <span class="badge bg-info">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ $image->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.product-images.edit', $image) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.product-images.destroy', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No images found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $images->links() }}
    </div>
@endsection
