@extends('layouts.frontend')

@section('title', 'Berita & Artikel - Utero Group')

@section('content')
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Berita & Artikel</h1>
        <p class="text-gray-600 mb-8">Informasi terbaru seputar produk dan kegiatan Utero Group</p>

        <form action="{{ route('posts.index') }}" method="GET" class="mb-8">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari artikel..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand focus:border-brand outline-none"
                >
                <button type="submit" class="bg-brand text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-brand-dark transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('posts.index') }}" class="border border-gray-300 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition group">
                        <div class="aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-gray-500 mb-2">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
                            <h2 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-brand transition">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 150) }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-medium text-brand hover:text-brand-dark inline-flex items-center gap-1">
                                Baca selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <p class="text-gray-500 text-lg">Belum ada artikel yang tersedia.</p>
            </div>
        @endif
    </div>
</section>
@endsection
