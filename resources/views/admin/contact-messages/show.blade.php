@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Pesan Kontak #{{ $contactMessage->id }}</h1>
        <div>
            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Message</div>
                <div class="card-body">
                    <p>{{ $contactMessage->message }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Sender Info</div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th style="width:120px;">Name</th>
                            <td>{{ $contactMessage->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $contactMessage->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $contactMessage->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td>{{ $contactMessage->subject }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $contactMessage->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Update Status</div>
                <div class="card-body">
                    <form action="{{ route('admin.contact-messages.update', $contactMessage) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="new" {{ $contactMessage->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="read" {{ $contactMessage->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $contactMessage->status === 'replied' ? 'selected' : '' }}>Replied</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
