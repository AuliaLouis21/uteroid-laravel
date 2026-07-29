@extends('layouts.frontend')

@section('title', 'News | Utero Advertising')
@section('meta_description', 'Berita terkini seputar Utero Advertising, produk, promo, dan tips periklanan di Malang.')
@section('og_type', 'website')

@php $noSidebar = true; $hideHeader = true; @endphp

@push('styles')
    @vite(['resources/css/news.css'])
@endpush

@section('hero')
<div class="news-hero">
    <div class="news-hero-content">
        <h1>NEWS</h1>
        <div class="news-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">/</span>
            <span class="current">News</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="news-container">
    <div class="news-layout">

        {{-- LEFT: ARTICLE GRID --}}
        <div>
            @if($posts->count())
            <div class="news-grid">
                @foreach($posts as $index => $post)
                <article class="news-card news-fade-in" style="transition-delay: {{ $index * 0.08 }}s;">
                    <a href="{{ route('posts.show', $post->slug) }}" class="news-card-thumb">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('images/placeholder-news.jpg') }}" alt="{{ $post->title }}" loading="lazy">
                        @endif
                        @if($post->category)
                            <span class="news-card-category">{{ $post->category->name }}</span>
                        @endif
                    </a>
                    <div class="news-card-body">
                        <div class="news-card-meta">
                            <span><i class="far fa-calendar-alt"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                            @if($post->category)
                                <span><i class="far fa-folder"></i>{{ $post->category->name }}</span>
                            @endif
                        </div>
                        <h3 class="news-card-title">
                            <a href="{{ route('posts.show', $post->slug) }}" style="text-decoration:none;color:inherit;">{{ $post->title }}</a>
                        </h3>
                        <p class="news-card-excerpt">{{ Str::limit(strip_tags($post->excerpt ?: $post->content), 100) }}</p>
                        <a href="{{ route('posts.show', $post->slug) }}" class="news-card-link">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="news-pagination">
                {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @else
            <div class="news-empty">
                <i class="far fa-newspaper"></i>
                <h3>Belum ada berita</h3>
                <p>Berita terbaru akan segera hadir di sini.</p>
            </div>
            @endif
        </div>

        {{-- RIGHT: SIDEBAR --}}
        <aside class="news-sidebar">

            {{-- Search --}}
            <div class="news-sidebar-widget">
                <div class="news-sidebar-title"><i class="fas fa-search"></i> Search News</div>
                <form action="{{ route('posts.index') }}" method="GET" class="news-search-form">
                    <input type="text" name="src" placeholder="Cari berita..." value="{{ request('src') }}">
                    <button type="submit"><i class="fas fa-arrow-right"></i></button>
                </form>
            </div>

            {{-- Recent Posts --}}
            <div class="news-sidebar-widget">
                <div class="news-sidebar-title"><i class="fas fa-clock"></i> Recent Posts</div>
                @foreach($recentPosts as $recent)
                <a href="{{ route('posts.show', $recent->slug) }}" class="news-recent-item">
                    <div class="news-recent-thumb">
                        @if($recent->image)
                            <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('images/placeholder-news.jpg') }}" alt="{{ $recent->title }}" loading="lazy">
                        @endif
                    </div>
                    <div class="news-recent-info">
                        <div class="news-recent-title">{{ $recent->title }}</div>
                        <div class="news-recent-date"><i class="far fa-calendar-alt mr-1"></i>{{ $recent->published_at ? $recent->published_at->format('M d, Y') : $recent->created_at->format('M d, Y') }}</div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Categories --}}
            @if($categories->count())
            <div class="news-sidebar-widget">
                <div class="news-sidebar-title"><i class="fas fa-folder"></i> Categories</div>
                <ul class="news-category-list">
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('posts.index', ['category' => $cat->slug]) }}">
                            <span>{{ $cat->name }}</span>
                            <span class="news-category-count">{{ $cat->posts_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Popular Tags --}}
            @if(count($tags))
            <div class="news-sidebar-widget">
                <div class="news-sidebar-title"><i class="fas fa-tags"></i> Popular Tags</div>
                <div class="news-tags">
                    @foreach($tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag]) }}" class="news-tag">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/news.js'])
@endpush
