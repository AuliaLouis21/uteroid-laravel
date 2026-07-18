@extends('layouts.frontend')

@section('title', 'Video Gallery | Utero Advertising')

@section('content')
<div style="padding:0 8px 8px 8px; overflow:hidden; width:100%; margin:0;">
    <div class="gallery-section">
        <h1><span class="accent">video</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
        @forelse($videos as $index => $video)
            @if($index > 0 && $index % 6 == 0)
                </div><div class="gallery-section">
            @endif
            <div class="video-item" style="margin-left:{{ $index % 6 == 0 ? '0px' : '24px' }};">
                <div class="img">
                    @if($video->url)
                        <img src="https://img.youtube.com/vi/{{ \Illuminate\Support\Str::afterLast($video->url, 'v=') }}/1.jpg" alt="{{ $video->title }}">
                    @endif
                </div>
                <div class="desc">
                    <a href="{{ $video->url }}" title="{{ $video->title }}" target="_blank">{{ $video->title }}</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada video tersedia.</p>
        @endforelse
    </div>
</div>
@endsection
