@extends('layouts.admin')

@section('title', 'User Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>User Detail</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role === 'editor')
                            <span class="badge bg-primary">Editor</span>
                        @else
                            <span class="badge bg-secondary">Viewer</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $user->updated_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
