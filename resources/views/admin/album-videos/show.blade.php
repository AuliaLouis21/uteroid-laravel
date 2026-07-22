@extends('layouts.admin')

@section('title', $video->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $video->title }}</h1>
        <div>
            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $video->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $video->slug }}</td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td><a href="{{ $video->url }}" target="_blank">{{ $video->url }}</a></td>
                </tr>
                <tr>
                    <th>Album</th>
                    <td>{{ $video->album->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $video->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td>{{ $video->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Preview</div>
        <div class="card-body text-center">
            @if($video->youtube_id)
                <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; max-width:100%;">
                    <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen title="{{ $video->title }}"></iframe>
                </div>
            @else
                <p class="text-muted">No URL available.</p>
            @endif
        </div>
    </div>
@endsection
