@extends('layouts.admin')

@section('title', 'Advertisements')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Advertisements</h1>
        <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary">Add New</a>
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
                        <th>Status</th>
                        <th>Link</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $ad)
                        <tr>
                            <td>{{ $ad->id }}</td>
                            <td>
                                @if($ad->image)
                                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" width="60" height="60" style="object-fit:cover; border-radius:4px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $ad->title }}</td>
                            <td>{{ $ad->slug }}</td>
                            <td>
                                @if($ad->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if($ad->link)
                                    <a href="{{ $ad->link }}" target="_blank" class="text-truncate d-inline-block" style="max-width:150px;">{{ $ad->link }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.advertisements.edit', $ad) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this advertisement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No advertisements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $advertisements->links() }}
    </div>
@endsection
