@extends('layouts.admin')

@section('title', 'Testimonial Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Testimonial Detail</h1>
        <div>
            @if($testimonial->status !== 'approved')
                <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="approved">
                    <button class="btn btn-success">Approve</button>
                </form>
            @endif
            @if($testimonial->status !== 'rejected')
                <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button class="btn btn-warning">Reject</button>
                </form>
            @endif
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Name</th>
                    <td>{{ $testimonial->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $testimonial->email }}</td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td>{{ $testimonial->company ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <span class="text-warning" style="font-size:1.5rem;">&#9733;</span>
                            @else
                                <span class="text-muted" style="font-size:1.5rem;">&#9733;</span>
                            @endif
                        @endfor
                        <span class="ms-2">({{ $testimonial->rating }}/5)</span>
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!! nl2br(e($testimonial->content)) !!}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($testimonial->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($testimonial->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $testimonial->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
