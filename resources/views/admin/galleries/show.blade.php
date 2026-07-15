@extends('layouts.admin')

@section('title', 'Gallery Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gallery Detail</h1>
        <div>
            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $gallery->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $gallery->slug }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $gallery->category->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($gallery->image)
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! nl2br(e($gallery->description)) !!}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $gallery->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
