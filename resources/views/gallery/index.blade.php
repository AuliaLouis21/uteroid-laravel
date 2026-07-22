@extends('layouts.frontend')

@section('title', 'Gallery | Utero Advertising')
@section('meta_description', 'Galeri foto, video, dan audio hasil karya Utero Advertising — portfolio periklanan dan percetakan di Malang.')
@section('meta_keywords', 'galeri utero, portfolio advertising, foto produk, video advertising malang')

@section('content')
<div class="py-6">
    {{-- Photo Gallery --}}
    <div class="content-card">
        <div class="page-title"><span class="accent">Image</span> Gallery</div>
        <div class="page-title-bar"></div>

        <div class="gallery-grid">
            @forelse($albums as $album)
                <div class="gallery-item">
                    <div class="img">
                        @if($album->photos->count())
                            <img src="{{ asset('storage/' . $album->photos->first()->filename) }}" alt="{{ $album->name }}" loading="lazy">
                        @else
                            <div class="flex items-center justify-center text-gray-400 h-full">
                                <i class="fas fa-images text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="desc">
                        <a href="{{ route('gallery.photos', $album->slug) }}" title="Lihat Album : {{ $album->name }}">{{ $album->name }}</a>
                        <span class="text-xs text-gray-400 block mt-1">{{ $album->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8"><i class="fas fa-images text-2xl mb-2 block"></i>Belum ada galeri foto.</p>
            @endforelse
        </div>
    </div>

    {{-- Video Gallery --}}
    <div class="content-card mt-4">
        <div class="page-title"><span class="accent">Video</span> Gallery</div>
        <div class="page-title-bar"></div>

        <div class="gallery-grid">
            @forelse($videos as $video)
                <div class="video-item">
                    <div class="img">
                        @if($video->youtube_id)
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}" loading="lazy">
                        @else
                            <div class="flex items-center justify-center text-gray-400 h-full">
                                <i class="fas fa-play-circle text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="desc">
                        <a href="{{ $video->url }}" title="{{ $video->title }}" target="_blank">{{ $video->title }}</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8"><i class="fas fa-video text-2xl mb-2 block"></i>Belum ada video.</p>
            @endforelse
        </div>
    </div>

    {{-- Audio Gallery --}}
    <div class="content-card mt-4">
        <div class="page-title"><span class="accent">Audio</span> Gallery</div>
        <div class="page-title-bar"></div>

        <div class="space-y-3">
            @forelse($audios as $audio)
                <div class="audio-item">
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="descmp3">
                        <span class="font-medium">{{ $audio->title }}</span>
                        <span class="text-gray-400 text-xs ml-2">{{ $audio->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8"><i class="fas fa-headphones text-2xl mb-2 block"></i>Belum ada audio.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
