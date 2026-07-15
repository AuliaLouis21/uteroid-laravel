@extends('layouts.admin')

@section('title', 'Category Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Category Detail</h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width:200px;">Name</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $category->slug }}</td>
                </tr>
                <tr>
                    <th>Total Galleries</th>
                    <td>{{ $category->galleries->count() }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($category->galleries->isNotEmpty())
        <div class="card">
            <div class="card-header">Galleries in this Category</div>
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->galleries as $gallery)
                            <tr>
                                <td>{{ $gallery->id }}</td>
                                <td>
                                    @if($gallery->image)
                                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $gallery->title }}</td>
                                <td>{{ $gallery->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
