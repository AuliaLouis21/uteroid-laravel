@extends('layouts.frontend')

@section('title', $post->title . ' | News | Utero Advertising')
@section('meta_description', strip_tags(substr($post->excerpt ?: strip_tags($post->content), 0, 160)))
@section('og_type', 'article')
@section('og_image', $post->image ? asset('storage/' . $post->image) : asset('images/banner-web.jpg'))

@php $noSidebar = true; $hideHeader = true; @endphp

@push('styles')
    @vite(['resources/css/news.css'])
@endpush

@section('hero')
<div class="news-detail-hero" style="background-image: url('{{ $post->image ? asset('storage/' . $post->image) : asset('images/banner-web.jpg') }}');">
    <div class="news-detail-hero-content">
        @if($post->category)
            <span class="news-detail-category">{{ $post->category->name }}</span>
        @endif
        <h1>{{ $post->title }}</h1>
        <div class="news-detail-hero-meta">
            <span><i class="far fa-calendar-alt"></i>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            <span><i class="far fa-user"></i>Utero Advertising</span>
            @if($post->category)
                <span><i class="far fa-folder"></i>{{ $post->category->name }}</span>
            @endif
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="news-detail-container">
    <div class="news-detail-layout">

        {{-- MAIN ARTICLE --}}
        <div>
            <article class="news-detail-body">

                {{-- Featured Image --}}
                @if($post->image)
                <div class="news-detail-featured">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                </div>
                @endif

                {{-- Content --}}
                <div class="news-detail-content">
                    {!! cleanHtml($post->content) !!}
                </div>

                {{-- Share --}}
                <div class="news-share">
                    <span class="news-share-label"><i class="fas fa-share-alt mr-1"></i>Share:</span>
                    <a href="#" class="news-share-btn facebook" data-network="facebook" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="news-share-btn twitter" data-network="twitter" title="Share on Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="news-share-btn whatsapp" data-network="whatsapp" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="news-share-btn linkedin" data-network="linkedin" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </article>

            {{-- Related Posts --}}
            @if(isset($relatedPosts) && $relatedPosts->count())
            <div class="news-related">
                <h3 class="news-related-title"><i class="fas fa-link mr-2"></i>Berita Terkait</h3>
                <div class="news-related-grid">
                    @foreach($relatedPosts as $related)
                    <article class="news-card news-fade-in">
                        <a href="{{ route('posts.show', $related->slug) }}" class="news-card-thumb">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" loading="lazy">
                            @else
                                <img src="{{ asset('images/placeholder-news.jpg') }}" alt="{{ $related->title }}" loading="lazy">
                            @endif
                            @if($related->category)
                                <span class="news-card-category">{{ $related->category->name }}</span>
                            @endif
                        </a>
                        <div class="news-card-body">
                            <div class="news-card-meta">
                                <span><i class="far fa-calendar-alt"></i>{{ $related->published_at ? $related->published_at->format('M d, Y') : $related->created_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="news-card-title">
                                <a href="{{ route('posts.show', $related->slug) }}" style="text-decoration:none;color:inherit;">{{ $related->title }}</a>
                            </h3>
                            <a href="{{ route('posts.show', $related->slug) }}" class="news-card-link">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- SIDEBAR --}}
        <aside class="news-sidebar">

            {{-- Search --}}
            <div class="news-sidebar-widget">
                <div class="news-sidebar-title"><i class="fas fa-search"></i> Search News</div>
                <form action="{{ route('posts.index') }}" method="GET" class="news-search-form">
                    <input type="text" name="src" placeholder="Cari berita...">
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
