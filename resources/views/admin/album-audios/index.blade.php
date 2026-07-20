@extends('layouts.admin')

@section('title', 'Audio')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Audio</h1>
        <a href="{{ route('admin.audio.create') }}" class="btn btn-primary">Add Audio</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Album</th>
                        <th>File</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audios as $audio)
                        <tr>
                            <td>{{ $audio->id }}</td>
                            <td>{{ $audio->title }}</td>
                            <td>{{ $audio->album->name ?? '-' }}</td>
                            <td>
                                @if($audio->filename)
                                    <audio controls style="height:30px; max-width:200px;">
                                        <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                                    </audio>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.audio.show', $audio) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('admin.audio.edit', $audio) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.audio.destroy', $audio) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this audio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No audio found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $audios->links() }}
    </div>
@endsection
