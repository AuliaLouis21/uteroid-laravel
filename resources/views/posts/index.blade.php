@extends('layouts.frontend')

@section('title', 'Berita | Utero Advertising')
@section('meta_description', 'Berita terkini seputar Utero Advertising, produk, promo, dan tips periklanan di Malang.')
@section('meta_keywords', 'berita advertising, berita utero, promo printing, tips periklanan malang')

@section('sidebar-left')
<div class="sidebar-left">
    <div class="sidebar-card">
        <div class="card-header">
            <i class="fas fa-th-large"></i>Product Category
        </div>
        <div class="category-list-scroll">
            <ul class="category-list">
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.category', $cat->slug) }}" title="category: {{ $cat->name }}">
                            <i class="fas fa-chevron-right"></i>{{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-newspaper mr-2"></i>Berita Terkini</div>
        <div class="page-title-bar"></div>

        @if(request('src'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 text-sm">
                <i class="fas fa-search mr-1"></i>Pencarian: "<strong>{{ request('src') }}</strong>"
                <a href="{{ route('posts.index') }}" class="text-brand ml-2 font-medium">Reset</a>
            </div>
        @endif

        <div class="space-y-4">
            @forelse($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="block no-underline group">
                    <div class="bg-white border border-gray-100 rounded-card p-5 hover:shadow-card transition-all duration-200 hover:border-brand/20">
                        <h3 class="text-base font-semibold mb-1 group-hover:text-brand transition-colors" style="color: #1A1A2E;">
                            {{ $post->title }}
                        </h3>
                        <span class="text-xs text-gray-400">
                            <i class="far fa-clock mr-1"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                        </span>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ strip_tags(substr($post->content, 0, 200)) }}...</p>
                    </div>
                </a>
            @empty
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-newspaper text-3xl mb-3 block"></i>
                    Belum ada berita.
                </div>
            @endforelse
        </div>

        <div class="flex justify-end mt-6">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
