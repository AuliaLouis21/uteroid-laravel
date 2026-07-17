@extends('layouts.frontend')

@section('title', 'Video - Galeri - Utero Group')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-gray-500 mb-8">
            <ol class="flex items-center gap-1.5 flex-wrap">
                <li><a href="{{ route('home') }}" class="hover:text-brand transition">Beranda</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-brand transition">Galeri</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-gray-900 font-medium">Video</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            @if(isset($album))
                Video: {{ $album->name }}
            @else
                Video
            @endif
        </h1>
        @if(isset($album) && $album->description)
            <p class="text-gray-600 mb-8">{{ $album->description }}</p>
        @endif

        <div x-data="{ modalOpen: false, videoUrl: '' }" @keydown.escape.window="modalOpen = false">
            @php
                $videoList = isset($album) ? $album->videos : $videos;
            @endphp

            @if(isset($videoList) && ($videoList instanceof \Illuminate\Pagination\LengthAwarePaginator ? $videoList->count() : count($videoList)))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($videoList as $video)
                        <div
                            class="group rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition cursor-pointer"
                            @click="modalOpen = true; videoUrl = '{{ $video->youtube_url ?? $video->url ?? '' }}'"
                        >
                            <div class="aspect-video bg-gray-900 flex items-center justify-center overflow-hidden relative">
                                @if($video->thumbnail)
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-300">
                                @elseif($video->youtube_url ?? $video->url)
                                    <img
                                        src="https://img.youtube.com/vi/{{ Str::afterLast($video->youtube_url ?? $video->url, '/') }}/mqdefault.jpg"
                                        alt="{{ $video->title }}"
                                        class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-300"
                                        onerror="this.style.display='none'"
                                    >
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                                        <svg class="w-6 h-6 text-red-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-white">
                                <h3 class="font-semibold text-gray-900 group-hover:text-brand transition">{{ $video->title }}</h3>
                                @if($video->description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $video->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($videoList instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-10">
                        {{ $videoList->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500">Belum ada video tersedia.</p>
                </div>
            @endif

            {{-- Video Modal --}}
            <div
                x-show="modalOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="modalOpen = false"
                class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
            >
                <button
                    @click="modalOpen = false"
                    class="absolute top-4 right-4 text-white/80 hover:text-white transition z-10"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div
                    @click.stop
                    class="w-full max-w-4xl aspect-video bg-black rounded-xl overflow-hidden shadow-2xl"
                >
                    <iframe
                        x-show="videoUrl"
                        :src="videoUrl"
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
