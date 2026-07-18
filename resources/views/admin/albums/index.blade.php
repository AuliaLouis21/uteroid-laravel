@extends('layouts.admin')

@section('title', 'Albums')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Albums</h1>
        <a href="{{ route('admin.albums.create') }}" class="btn btn-primary">Add Album</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Photos</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $album)
                        <tr>
                            <td>{{ $album->id }}</td>
                            <td>{{ $album->name }}</td>
                            <td>{{ $album->category->name ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $album->photos_count }}</span></td>
                            <td>{{ $album->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this album and all its photos?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No albums found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $albums->links() }}
    </div>
@endsection
