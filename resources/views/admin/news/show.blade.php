@extends('layouts.admin')

@section('title', 'News Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>News Detail</h1>
        <div>
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $news->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $news->slug }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Excerpt</th>
                    <td>{{ $news->excerpt ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!! nl2br(e($news->content)) !!}</td>
                </tr>
                <tr>
                    <th>Published At</th>
                    <td>{{ $news->published_at?->format('d M Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $news->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
