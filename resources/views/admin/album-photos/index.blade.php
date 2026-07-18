@extends('layouts.admin')

@section('title', 'Album Photos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Album Photos</h1>
        <a href="{{ route('admin.album-photos.create') }}" class="btn btn-primary">Add Photo</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Album</th>
                        <th>Caption</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($photos as $photo)
                        <tr>
                            <td>{{ $photo->id }}</td>
                            <td>
                                @if($photo->filename)
                                    <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption }}" width="60" height="60" style="object-fit:cover; border-radius:4px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $photo->album->name ?? '-' }}</td>
                            <td>{{ $photo->caption ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.album-photos.edit', $photo) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.album-photos.destroy', $photo) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this photo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No photos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $photos->links() }}
    </div>
@endsection
