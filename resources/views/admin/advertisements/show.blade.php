@extends('layouts.admin')

@section('title', 'Advertisement Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Advertisement Detail</h1>
        <div>
            <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.advertisements.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Title</th>
                    <td>{{ $advertisement->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $advertisement->slug }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($advertisement->image)
                            <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->title }}" width="300" style="border-radius:4px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!! nl2br(e($advertisement->content)) !!}</td>
                </tr>
                <tr>
                    <th>Link</th>
                    <td>
                        @if($advertisement->link)
                            <a href="{{ $advertisement->link }}" target="_blank">{{ $advertisement->link }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($advertisement->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $advertisement->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
