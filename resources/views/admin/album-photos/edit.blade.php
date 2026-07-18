@extends('layouts.admin')

@section('title', 'Edit Album Photo')

@section('content')
    <h1>Edit Album Photo</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.album-photos.update', $albumPhoto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="album_id" class="form-label">Album <span class="text-danger">*</span></label>
                    <select name="album_id" id="album_id" class="form-select @error('album_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Album --</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id', $albumPhoto->album_id) == $album->id ? 'selected' : '' }}>{{ $album->name }}</option>
                        @endforeach
                    </select>
                    @error('album_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="filename" class="form-label">Photo</label>
                    @if($albumPhoto->filename)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $albumPhoto->filename) }}" alt="{{ $albumPhoto->caption }}" width="120" height="120" style="object-fit:cover; border-radius:4px;">
                        </div>
                    @endif
                    <input type="file" name="filename" id="filename" class="form-control @error('filename') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                    @error('filename')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Max 2MB. Format: JPG, JPEG, PNG, WebP. Leave empty to keep current photo.</small>
                </div>

                <div class="mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <input type="text" name="caption" id="caption" class="form-control @error('caption') is-invalid @enderror" value="{{ old('caption', $albumPhoto->caption) }}">
                    @error('caption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('admin.album-photos.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
