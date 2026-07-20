@extends('layouts.frontend')

@section('title', 'Gallery | Utero Advertising')

@section('content')
<div style="padding:0 8px 8px 8px; overflow:hidden; width:100%; margin:0;">
    <div class="gallery-section">
        <h1><span class="accent">image</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
        @forelse($albums as $index => $album)
            @if($index > 0 && $index % 3 == 0)
                </div><div class="gallery-section">
            @endif
            <div class="gallery-item" style="{{ ($index + 1) % 3 == 0 ? 'margin-right:0px;' : 'margin-right:26px;' }}">
                <div class="img">
                    @if($album->photos->count())
                        <img src="{{ asset('storage/' . $album->photos->first()->filename) }}" alt="{{ $album->name }}">
                    @else
                        <div class="h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>
                <div class="desc">
                    <a href="{{ route('gallery.photos', $album->slug) }}" title="Lihat Album : {{ $album->name }}">{{ $album->name }}</a><b>&rarr;</b> {{ $album->created_at->format('F jS, Y') }}
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada galeri foto.</p>
        @endforelse
        @if($albums->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Images &rarr;</a></span>
        @endif
    </div>

    <div class="gallery-section">
        <h1><span class="accent">video</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
        @forelse($videos as $index => $video)
            @if($index > 0 && $index % 3 == 0)
                </div><div class="gallery-section">
            @endif
            <div class="video-item" style="{{ ($index + 1) % 3 == 0 ? 'margin-right:0px;' : '' }}">
                <div class="img">
                    @if($video->youtube_id)
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/1.jpg" alt="{{ $video->title }}">
                    @else
                        <div class="h-full flex items-center justify-center text-gray-400"><i class="fa fa-play"></i></div>
                    @endif
                </div>
                <div class="desc">
                    <a href="{{ $video->url }}" title="{{ $video->title }}" target="_blank">{{ $video->title }}</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada video.</p>
        @endforelse
        @if($videos->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Videos &rarr;</a></span>
        @endif
    </div>

    <div class="gallery-section">
        <h1><span class="accent">audio</span>gallery <span style="font-size:40px;">&raquo;</span></h1>
        @forelse($audios as $index => $audio)
            @if($index > 0 && $index % 3 == 0)
                </div><div class="gallery-section">
            @endif
            <div class="audio-item" style="{{ ($index + 1) % 3 == 0 ? 'margin-right:0px;' : 'margin-right:26px;' }}">
                <div>
                    <audio controls style="width:264px;">
                        <source src="{{ asset('storage/' . $audio->filename) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <div class="descmp3">
                    {{ $audio->title }}<b>&rarr;</b> {{ $audio->created_at->format('F jS, Y') }}
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada audio.</p>
        @endforelse
        @if($audios->count())
            <span class="section-divider"><a href="{{ route('gallery.index') }}">View All Audio &rarr;</a></span>
        @endif
    </div>
</div>
@endsection
