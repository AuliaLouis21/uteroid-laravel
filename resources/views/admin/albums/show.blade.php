@extends('layouts.admin')

@section('title', $album->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $album->name }}</h1>
        <div>
            <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Name</th>
                    <td>{{ $album->name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $album->slug }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $album->category->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $album->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Photos</th>
                    <td>{{ $album->photos->count() }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($album->photos->count())
    <div class="card">
        <div class="card-header">Photos</div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($album->photos as $photo)
                    <div class="col-md-3">
                        <div class="aspect-square bg-gray-200 rounded overflow-hidden">
                            <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption }}" class="w-100 h-100" style="object-fit:cover;">
                        </div>
                        @if($photo->caption)
                            <p class="text-muted small mt-1">{{ $photo->caption }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection
