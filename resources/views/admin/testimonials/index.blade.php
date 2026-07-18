@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Testimonials</h1>
        <div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            <a href="{{ route('admin.testimonials.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending</a>
            <a href="{{ route('admin.testimonials.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') === 'approved' ? 'btn-success' : 'btn-outline-success' }}">Approved</a>
            <a href="{{ route('admin.testimonials.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Rejected</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Rating</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->company ?? '-' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $item->rating)
                                        <span class="text-warning">&#9733;</span>
                                    @else
                                        <span class="text-muted">&#9733;</span>
                                    @endif
                                @endfor
                            </td>
                            <td>{{ Str::limit($item->content, 50) }}</td>
                            <td>
                                @if($item->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.testimonials.show', $item) }}" class="btn btn-sm btn-info">View</a>
                                @if($item->status !== 'approved')
                                    <form action="{{ route('admin.testimonials.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                @endif
                                @if($item->status !== 'rejected')
                                    <form action="{{ route('admin.testimonials.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-warning">Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No testimonials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $testimonials->withQueryString()->links() }}
    </div>
@endsection
