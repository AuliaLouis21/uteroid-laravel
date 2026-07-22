@extends('layouts.admin')

@section('title', 'Edit Advertisement')

@section('content')
    <h1>Edit Advertisement</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $advertisement->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $advertisement->slug) }}">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to auto-generate from title.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $advertisement->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            @if($advertisement->image)
                                <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->title }}" width="150" height="150" style="object-fit:cover; border-radius:4px;">
                            @else
                                <p class="text-muted">No image</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="image" class="form-label">New Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to keep current. Max 2MB.</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="link" class="form-label">Link URL</label>
                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $advertisement->link) }}" placeholder="https://">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $advertisement->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <a href="{{ route('admin.advertisements.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
