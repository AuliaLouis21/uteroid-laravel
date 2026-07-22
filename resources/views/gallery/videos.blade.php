@extends('layouts.frontend')

@section('title', 'Video Gallery | Utero Advertising')

@section('content')
<div style="padding:0 8px 8px 8px; overflow:hidden; width:100%; margin:0;">
    <div class="gallery-section">
        <h1><span class="accent">video</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
    @forelse($videos as $video)
        <div class="video-item">
            <div class="img">
                @if($video->youtube_id)
                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}">
                @else
                    <div style="display:flex; align-items:center; justify-content:center; color:#999; height:100%;"><i class="fa fa-play"></i></div>
                @endif
            </div>
            <div class="desc">
                <a href="{{ $video->url }}" title="{{ $video->title }}" target="_blank">{{ $video->title }}</a>
            </div>
        </div>
    @empty
        <p style="color:#999;">Belum ada video tersedia.</p>
    @endforelse
    </div>
</div>
@endsection
