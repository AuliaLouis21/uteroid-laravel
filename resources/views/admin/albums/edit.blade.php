@extends('layouts.admin')

@section('title', 'Edit Album - ' . $album->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Edit Album</h1>
        <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="row">
        {{-- Album Info --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Album Information</div>
                <div class="card-body">
                    <form action="{{ route('admin.albums.update', $album) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $album->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $album->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $album->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $album->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Album</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Photos Management --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Photos ({{ $album->photos->count() }})</span>
                </div>
                <div class="card-body">
                    {{-- Upload Form --}}
                    <form action="{{ route('admin.albums.photos.store', $album) }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded">
                        @csrf
                        <div class="mb-2">
                            <input type="file" name="filename" class="form-control @error('filename') is-invalid @enderror" accept="image/jpeg,image/png,image/webp" required>
                            @error('filename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <input type="text" name="caption" class="form-control" placeholder="Caption (opsional)">
                            <button type="submit" class="btn btn-success btn-sm">Upload</button>
                        </div>
                    </form>

                    {{-- Photo Grid --}}
                    @if($album->photos->count())
                        <div class="row g-2">
                            @foreach($album->photos as $photo)
                                <div class="col-4 position-relative">
                                    <div class="aspect-square bg-gray-200 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption }}" class="w-100 h-100" style="object-fit:cover;">
                                    </div>
                                    @if($photo->caption)
                                        <small class="text-muted d-block text-truncate mt-1">{{ $photo->caption }}</small>
                                    @endif
                                    <form action="{{ route('admin.albums.photos.delete', [$album, $photo]) }}" method="POST" class="position-absolute top-0 end-0" onsubmit="return confirm('Delete this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm m-1" style="padding: 2px 6px;">&times;</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada foto. Upload foto pertama di atas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
