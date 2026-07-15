@extends('layouts.admin')

@section('title', 'Edit Product Image')

@section('content')
    <h1>Edit Product Image</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.product-images.update', $productImage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $productImage->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <div>
                        @if($productImage->filename)
                            <img src="{{ asset('storage/' . $productImage->filename) }}" alt="{{ $productImage->product->name ?? '' }}" width="150" height="150" style="object-fit:cover; border-radius:4px;">
                        @else
                            <p class="text-muted">No image</p>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="filename" class="form-label">New Image</label>
                    <input type="file" name="filename" id="filename" class="form-control @error('filename') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                    @error('filename')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty to keep current image. Max 2MB. Format: JPG, JPEG, PNG, WebP.</small>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_thumbnail" value="0">
                        <input type="checkbox" name="is_thumbnail" id="is_thumbnail" class="form-check-input" value="1" {{ old('is_thumbnail', $productImage->is_thumbnail) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_thumbnail">Thumbnail</label>
                    </div>
                </div>

                <a href="{{ route('admin.product-images.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
