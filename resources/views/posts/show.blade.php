@extends('layouts.frontend')

@section('title', $post->title . ' - Utero Group')

@section('content')
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-gray-500 mb-8">
            <ol class="flex items-center gap-1.5 flex-wrap">
                <li><a href="{{ route('home') }}" class="hover:text-brand transition">Beranda</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('posts.index') }}" class="hover:text-brand transition">Berita</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-gray-900 font-medium truncate max-w-xs">{{ $post->title }}</li>
            </ol>
        </nav>

        <article>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
            <p class="text-sm text-gray-500 mb-6">
                Dipublikasikan pada {{ $post->published_at?->format('d F Y') ?? $post->created_at->format('d F Y') }}
            </p>

            @if($post->image)
                <div class="mb-8 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
                </div>
            @endif

            <div class="max-w-none">
                {!! $post->content !!}
            </div>
        </article>
    </div>
</section>

@if(isset($relatedPosts) && $relatedPosts->count())
<section class="py-12 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Artikel Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPosts as $related)
                <a href="{{ route('posts.show', $related->slug) }}" class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition group">
                    <div class="aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 mb-1">{{ $related->published_at?->format('d M Y') ?? $related->created_at->format('d M Y') }}</p>
                        <h3 class="font-semibold text-gray-900 group-hover:text-brand transition line-clamp-2">{{ $related->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
