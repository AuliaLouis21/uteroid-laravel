@extends('layouts.admin')

@section('title', 'Page Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Page Detail</h1>
        <div>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $page->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $page->slug }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($page->image)
                            <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!! nl2br(e($page->content)) !!}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $page->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
