@extends('layouts.frontend')

@section('title', $album->name . ' - Galeri - Utero Group')

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
                <li class="text-gray-900 font-medium">{{ $album->name }}</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $album->name }}</h1>
        @if($album->description)
            <p class="text-gray-600 mb-8">{{ $album->description }}</p>
        @endif

        <div x-data="{ open: false, src: '', alt: '' }" @keydown.escape.window="open = false">
            @if($album->photos->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                    @foreach($album->photos as $photo)
                        <button
                            @click="open = true; src = '{{ asset('storage/' . $photo->path) }}'; alt = '{{ addslashes($photo->caption ?? $album->name) }}'"
                            class="group aspect-square rounded-lg overflow-hidden bg-gray-100 border border-gray-200 hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-brand"
                        >
                            <img
                                src="{{ asset('storage/' . $photo->path) }}"
                                alt="{{ $photo->caption ?? $album->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                loading="lazy"
                            >
                        </button>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500">Album ini belum memiliki foto.</p>
                </div>
            @endif

            {{-- Lightbox Overlay --}}
            <div
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
                class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 cursor-zoom-out"
            >
                <button
                    @click="open = false"
                    class="absolute top-4 right-4 text-white/80 hover:text-white transition"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img
                    :src="src"
                    :alt="alt"
                    @click.stop
                    class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                >
            </div>
        </div>
    </div>
</section>
@endsection
