@extends('layouts.admin')

@section('title', 'Videos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Videos</h1>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">Add Video</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Album</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <td>{{ $video->id }}</td>
                            <td>
                                @if($video->youtube_id)
                                    <a href="{{ $video->url }}" target="_blank">
                                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}" width="80" height="60" style="object-fit:cover; border-radius:4px;">
                                    </a>
                                @else
                                    <span class="text-muted">No URL</span>
                                @endif
                            </td>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->album->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this video?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No videos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $videos->links() }}
    </div>
@endsection
