@extends('layouts.frontend')

@section('title', $album->name . ' | Galeri | Utero Advertising')

@section('content')
<div style="padding:0 8px 8px 8px; overflow:hidden; width:100%; margin:0;">
    <div class="detail-section">
        <h1 style="border-bottom:1px solid #999; padding-bottom:4px; margin-bottom:8px;">
            {{ $album->name }}
        </h1>
        @if($album->description)
            <p class="mb-4 text-gray-600">{{ $album->description }}</p>
        @endif
    </div>

    <div class="gallery-section">
    @forelse($album->photos as $photo)
        <div class="gallery-item">
            <div class="img" style="height:auto;">
                <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption ?? $album->name }}" loading="lazy" style="height:132px; width:100%; object-fit:cover;">
            </div>
            @if($photo->caption)
                <div class="desc">{{ $photo->caption }}</div>
            @endif
        </div>
    @empty
        <p style="color:#999;">Album ini belum memiliki foto.</p>
    @endforelse
    </div>
</div>
@endsection
