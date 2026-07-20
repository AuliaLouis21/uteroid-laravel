@extends('layouts.admin')

@section('title', 'Edit Audio - ' . $audio->title)

@section('content')
    <h1>Edit Audio</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.audio.update', $audio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $audio->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $audio->slug) }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if($audio->filename)
                    <div class="mb-3">
                        <label class="form-label">Current Audio</label>
                        <div>
                            <audio controls style="height:40px; max-width:300px;">
                                <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="filename" class="form-label">Audio File <small class="text-muted">(kosongkan jika tidak diganti)</small></label>
                    <input type="file" name="filename" id="filename" class="form-control @error('filename') is-invalid @enderror" accept="audio/mpeg,audio/wav,audio/ogg,audio/aac,audio/m4a">
                    @error('filename')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Max 10MB. Format: MP3, WAV, OGG, AAC, M4A.</small>
                </div>

                <div class="mb-3">
                    <label for="album_id" class="form-label">Album</label>
                    <select name="album_id" id="album_id" class="form-select @error('album_id') is-invalid @enderror">
                        <option value="">-- None (standalone) --</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id', $audio->album_id) == $album->id ? 'selected' : '' }}>{{ $album->name }}</option>
                        @endforeach
                    </select>
                    @error('album_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $audio->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
