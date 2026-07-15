@extends('layouts.admin')

@section('title', 'Galleries')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Galleries</h1>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $gallery)
                        <tr>
                            <td>{{ $gallery->id }}</td>
                            <td>
                                @if($gallery->image)
                                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="60" height="60" style="object-fit:cover; border-radius:4px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $gallery->title }}</td>
                            <td>{{ $gallery->slug }}</td>
                            <td>{{ $gallery->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this gallery?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No galleries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $galleries->links() }}
    </div>
@endsection
