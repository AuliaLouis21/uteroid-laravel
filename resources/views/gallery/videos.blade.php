@extends('layouts.frontend')

@section('title', 'Video Gallery | Utero Advertising')

@section('content')
<div class="py-6">
    <div class="content-card">
        <a href="{{ route('gallery.index') }}" class="text-sm text-brand no-underline hover:text-gold mb-4 inline-block">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Gallery
        </a>
        <div class="page-title"><span class="accent">Video</span> Gallery</div>
        <div class="page-title-bar"></div>

        <div class="gallery-grid">
            @forelse($videos as $video)
                <div class="video-item">
                    <div class="img">
                        @if($video->youtube_id)
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}">
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
                <p class="text-gray-400 text-center py-8"><i class="fas fa-video text-2xl mb-2 block"></i>Belum ada video tersedia.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
