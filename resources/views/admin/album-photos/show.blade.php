@extends('layouts.admin')

@section('title', 'Album Photo Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Album Photo Detail</h1>
        <div>
            <a href="{{ route('admin.album-photos.edit', $albumPhoto) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.album-photos.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Photo</th>
                    <td>
                        @if($albumPhoto->filename)
                            <img src="{{ asset('storage/' . $albumPhoto->filename) }}" alt="{{ $albumPhoto->caption }}" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Album</th>
                    <td>{{ $albumPhoto->album->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Caption</th>
                    <td>{{ $albumPhoto->caption ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $albumPhoto->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
