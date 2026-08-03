@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Pesan Kontak</h1>
        <div>
            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'new']) }}" class="btn btn-sm {{ request('status') === 'new' ? 'btn-warning' : 'btn-outline-warning' }}">New</a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" class="btn btn-sm {{ request('status') === 'read' ? 'btn-info' : 'btn-outline-info' }}">Read</a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'replied']) }}" class="btn btn-sm {{ request('status') === 'replied' ? 'btn-success' : 'btn-outline-success' }}">Replied</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone ?? '-' }}</td>
                            <td>
                                @if($message->status === 'replied')
                                    <span class="badge bg-success">Replied</span>
                                @elseif($message->status === 'read')
                                    <span class="badge bg-info">Read</span>
                                @else
                                    <span class="badge bg-warning">New</span>
                                @endif
                            </td>
                            <td>{{ $message->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-sm btn-info">View</a>
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $messages->withQueryString()->links() }}
    </div>
@endsection
