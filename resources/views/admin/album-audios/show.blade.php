@extends('layouts.admin')

@section('title', $audio->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $audio->title }}</h1>
        <div>
            <a href="{{ route('admin.audio.edit', $audio) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $audio->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $audio->slug }}</td>
                </tr>
                <tr>
                    <th>Album</th>
                    <td>{{ $audio->album->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $audio->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td>{{ $audio->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Preview</div>
        <div class="card-body text-center">
            @if($audio->filename)
                <audio controls style="width:100%; max-width:500px;">
                    <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <div class="mt-2">
                    <small class="text-muted">{{ $audio->filename }}</small>
                </div>
            @else
                <p class="text-muted">No audio file available.</p>
            @endif
        </div>
    </div>
@endsection
