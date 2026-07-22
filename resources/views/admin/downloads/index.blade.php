@extends('layouts.admin')

@section('title', 'Downloads')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Downloads</h4>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Upload File</div>
            <div class="card-body">
                <form action="{{ route('admin.downloads.store-file') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File (maks. 10MB)</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" id="file" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload File</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Tambah Link Google Drive</div>
            <div class="card-body">
                <form action="{{ route('admin.downloads.store-gdrive') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="gdrive_name" class="form-label">Nama File</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="gdrive_name" placeholder="Contoh: Brosur 2026" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gdrive_url" class="form-label">URL Google Drive</label>
                        <input type="url" class="form-control @error('gdrive_url') is-invalid @enderror" name="gdrive_url" id="gdrive_url" placeholder="https://drive.google.com/file/d/..." required>
                        @error('gdrive_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">Tambah Link</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Daftar Downloads</div>
    <div class="card-body p-0">
        @if($downloads->count())
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th style="width:80px;">Tipe</th>
                        <th style="width:100px;">Ukuran</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($downloads as $dl)
                        <tr>
                            <td>
                                @if($dl->isFile())
                                    <i class="fa {{ $dl->file_icon }} me-1"></i>
                                @else
                                    <i class="fa fa-link me-1"></i>
                                @endif
                                {{ $dl->name }}
                                @if($dl->isFile() && $dl->extension)
                                    <span class="text-muted">.{{ $dl->extension }}</span>
                                @endif
                            </td>
                            <td>
                                @if($dl->isFile())
                                    <span class="badge bg-primary">File</span>
                                @else
                                    <span class="badge bg-success">GDrive</span>
                                @endif
                            </td>
                            <td>{{ $dl->isFile() ? $dl->formatted_size : '-' }}</td>
                            <td>
                                @if($dl->isFile())
                                    <a href="{{ route('download.file', $dl->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">Download</a>
                                @else
                                    <a href="{{ $dl->gdrive_url }}" class="btn btn-sm btn-outline-success" target="_blank">Buka</a>
                                @endif
                                <form action="{{ route('admin.downloads.destroy', $dl->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center py-3">
                {{ $downloads->links() }}
            </div>
        @else
            <div class="text-center text-muted py-4">Belum ada download yang tersedia.</div>
        @endif
    </div>
</div>
@endsection
