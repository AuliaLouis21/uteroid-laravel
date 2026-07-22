@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')
    <h1>Edit Page</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $page->slug) }}">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to auto-generate from title.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            @if($page->image)
                                <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" width="150" height="150" style="object-fit:cover; border-radius:4px;">
                            @else
                                <p class="text-muted">No image</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">New Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                        <div id="image-preview" class="mt-2"></div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to keep current image. Max 2MB.</small>
                    </div>
                </div>

                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#content',
    height: 400,
    menubar: true,
    plugins: 'lists link image table code help wordcount',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat | code',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; }'
});
document.getElementById('image').addEventListener('change', function(e) {
    var preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    if (e.target.files[0]) {
        var img = document.createElement('img');
        img.src = URL.createObjectURL(e.target.files[0]);
        img.style.maxWidth = '200px';
        img.style.borderRadius = '4px';
        preview.appendChild(img);
    }
});
</script>
@endpush
