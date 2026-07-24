@extends('layouts.frontend')

@section('title', $album->name . ' | Galeri | Utero Advertising')

@section('content')
<div class="py-6">
    <div class="content-card">
        <a href="{{ route('gallery.index') }}" class="text-sm text-brand no-underline hover:text-white mb-4 inline-block">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Gallery
        </a>
        <div class="page-title">{{ $album->name }}</div>
        <div class="page-title-bar"></div>
        @if($album->description)
            <p class="text-gray-500 mb-6">{{ $album->description }}</p>
        @endif

        <div class="gallery-grid">
            @forelse($album->photos as $photo)
                <div class="gallery-item">
                    <div class="img" style="height: auto;">
                        <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption ?? $album->name }}" loading="lazy" class="w-full object-cover" style="height: 220px;">
                    </div>
                    @if($photo->caption)
                        <div class="desc">{{ $photo->caption }}</div>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-center py-8"><i class="fas fa-images text-2xl mb-2 block"></i>Album ini belum memiliki foto.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
