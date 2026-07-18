@extends('layouts.frontend')

@section('title', 'Galeri - Utero Group')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Galeri</h1>
        <p class="text-gray-600 mb-8">Dokumentasi foto, video, dan audio dari kegiatan Utero Group</p>

        <div x-data="{ tab: 'foto' }">
            <div class="flex gap-1 border-b border-gray-200 mb-8">
                <button
                    @click="tab = 'foto'"
                    :class="tab === 'foto' ? 'border-brand text-brand' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition -mb-px"
                >
                    Foto
                </button>
                <button
                    @click="tab = 'video'"
                    :class="tab === 'video' ? 'border-brand text-brand' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition -mb-px"
                >
                    Video
                </button>
                <button
                    @click="tab = 'audio'"
                    :class="tab === 'audio' ? 'border-brand text-brand' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition -mb-px"
                >
                    Audio
                </button>
            </div>

            {{-- Photos Tab --}}
            <div x-show="tab === 'foto'" x-cloak>
                @if(isset($albums) && $albums->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($albums as $album)
                            <a href="{{ route('gallery.photos', $album->slug) }}" class="group block rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition">
                                <div class="aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
                                    @if($album->cover)
                                        <img src="{{ asset('storage/' . $album->cover) }}" alt="{{ $album->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @elseif($album->photos->count())
                                        <img src="{{ asset('storage/' . $album->photos->first()->filename) }}" alt="{{ $album->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-brand transition">{{ $album->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $album->photos_count ?? $album->photos->count() }} foto</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">Belum ada album foto.</p>
                    </div>
                @endif
            </div>

            {{-- Videos Tab --}}
            <div x-show="tab === 'video'" x-cloak>
                @if(isset($videos) && $videos->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($videos as $video)
                            <a href="{{ route('gallery.videos', isset($album) ? ['album' => $album->slug] : []) }}" class="group block rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition">
                                <div class="aspect-video bg-gray-900 flex items-center justify-center overflow-hidden relative">
                                    @if($video->thumbnail)
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900"></div>
                                    @endif
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                                            <svg class="w-6 h-6 text-brand ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-brand transition">{{ $video->title }}</h3>
                                    @if($video->description)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $video->description }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">Belum ada video tersedia.</p>
                    </div>
                @endif
            </div>

            {{-- Audios Tab --}}
            <div x-show="tab === 'audio'" x-cloak>
                @if(isset($audios) && $audios->count())
                    <div class="space-y-3">
                        @foreach($audios as $audio)
                            <div class="flex items-center gap-4 bg-gray-50 border border-gray-100 rounded-xl p-4 hover:shadow-md transition">
                                <button
                                    x-data="{ playing: false }"
                                    @click="playing = !playing"
                                    class="w-12 h-12 flex-shrink-0 bg-brand hover:bg-brand-dark rounded-full flex items-center justify-center text-white transition"
                                >
                                    <svg x-show="!playing" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    <svg x-show="playing" x-cloak class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                    </svg>
                                </button>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 truncate">{{ $audio->title }}</h3>
                                    @if($audio->description)
                                        <p class="text-sm text-gray-500 truncate">{{ $audio->description }}</p>
                                    @endif
                                </div>
                                @if($audio->duration)
                                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $audio->duration }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                        <p class="text-gray-500">Belum ada audio tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
