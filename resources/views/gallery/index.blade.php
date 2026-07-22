@extends('layouts.frontend')

@section('title', 'Gallery | Utero Advertising')
@section('meta_description', 'Galeri foto, video, dan audio hasil karya Utero Advertising — portfolio periklanan dan percetakan di Malang.')
@section('meta_keywords', 'galeri utero, portfolio advertising, foto produk, video advertising malang')

@section('content')
<div style="padding:0 8px 8px 8px; overflow:hidden; width:100%; margin:0;">
    <div class="gallery-section">
        <h1><span class="accent">image</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
    @forelse($albums as $album)
        <div class="gallery-item">
            <div class="img">
                @if($album->photos->count())
                    <img src="{{ asset('storage/' . $album->photos->first()->filename) }}" alt="{{ $album->name }}" loading="lazy">
                @else
                    <div style="display:flex; align-items:center; justify-content:center; color:#999; height:100%;">No Image</div>
                @endif
            </div>
            <div class="desc">
                <a href="{{ route('gallery.photos', $album->slug) }}" title="Lihat Album : {{ $album->name }}">{{ $album->name }}</a><b>&rarr;</b> {{ $album->created_at->format('F jS, Y') }}
            </div>
        </div>
    @empty
        <p style="color:#999;">Belum ada galeri foto.</p>
    @endforelse
        @if($albums->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Images &rarr;</a></span>
        @endif
    </div>

    <div class="gallery-section">
        <h1><span class="accent">video</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
    @forelse($videos as $video)
        <div class="video-item">
            <div class="img">
                @if($video->youtube_id)
                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}" loading="lazy">
                @else
                    <div style="display:flex; align-items:center; justify-content:center; color:#999; height:100%;"><i class="fa fa-play"></i></div>
                @endif
            </div>
            <div class="desc">
                <a href="{{ $video->url }}" title="{{ $video->title }}" target="_blank">{{ $video->title }}</a>
            </div>
        </div>
    @empty
        <p style="color:#999;">Belum ada video.</p>
    @endforelse
        @if($videos->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Videos &rarr;</a></span>
        @endif
    </div>

    <div class="gallery-section">
        <h1><span class="accent">audio</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
    @forelse($audios as $audio)
        <div class="audio-item">
            <div>
                <audio controls style="width:100%;">
                    <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
            <div class="descmp3">
                {{ $audio->title }}<b>&rarr;</b> {{ $audio->created_at->format('F jS, Y') }}
            </div>
        </div>
    @empty
        <p style="color:#999;">Belum ada audio.</p>
    @endforelse
        @if($audios->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Audio &rarr;</a></span>
        @endif
    </div>
</div>
@endsection
