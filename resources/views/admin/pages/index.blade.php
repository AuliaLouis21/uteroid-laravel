@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Add New</a>
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
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>
                                @if($page->image)
                                    <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" width="60" height="60" style="object-fit:cover; border-radius:4px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this page?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $pages->links() }}
    </div>
@endsection
