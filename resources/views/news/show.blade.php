@extends('layouts.frontend')

@section('title', $post->title . ' | News | Utero Advertising')
@section('meta_description', strip_tags(substr($post->excerpt ?: strip_tags($post->content), 0, 160)))
@section('og_type', 'article')
@section('og_image', $post->image ? asset('storage/' . $post->image) : asset('images/banner-web.jpg'))

@section('sidebar-left')
<div class="sidebar-left">
    {{-- Search --}}
    <div class="sidebar-card">
        <div class="card-header">
            <i class="fas fa-search"></i>Cari Berita
        </div>
        <div style="padding: 16px;">
            <form action="{{ route('posts.index') }}" method="GET" style="display: flex; gap: 0;">
                <input type="text" name="src" placeholder="Ketik kata kunci..." style="flex: 1; border: 1px solid #E5E7EB; border-right: none; border-radius: 8px 0 0 8px; padding: 10px 14px; font-size: 14px; outline: none;">
                <button type="submit" style="background: #ce181e; color: #fff; border: none; border-radius: 0 8px 8px 0; padding: 10px 16px; cursor: pointer;"><i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>

    {{-- News Categories --}}
    @if($categories->count())
    <div class="sidebar-card mt-4">
        <div class="card-header">
            <i class="fas fa-folder"></i>Kategori Berita
        </div>
        <ul class="category-list">
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('posts.index', ['category' => $cat->slug]) }}" title="category: {{ $cat->name }}">
                        <i class="fas fa-chevron-right"></i>
                        {{ $cat->name }}
                        <span class="ml-auto text-xs text-gray-400">({{ $cat->posts_count }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Quick Links --}}
    <div class="sidebar-card mt-4">
        <div class="card-header">
            <i class="fas fa-bolt"></i>Quick Links
        </div>
        <ul class="category-list">
            <li><a href="{{ route('products.index') }}"><i class="fas fa-shopping-cart"></i>Price List</a></li>
            <li><a href="{{ route('download.index') }}"><i class="fas fa-download"></i>Download</a></li>
            <li><a href="{{ route('order.create') }}"><i class="fas fa-paper-plane"></i>Pesan Sekarang</a></li>
            <li><a href="{{ route('contact.index') }}"><i class="fas fa-envelope"></i>Hubungi Kami</a></li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="content-card">
        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-400 mb-4">
            <a href="{{ route('home') }}" style="color: #ce181e;">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('posts.index') }}" style="color: #ce181e;">News</a>
            <span class="mx-2">/</span>
            <span>{{ Str::limit($post->title, 40) }}</span>
        </div>

        {{-- Title --}}
        <h1 class="page-title" style="color: #000000;">{{ $post->title }}</h1>
        <div class="page-title-bar"></div>

        {{-- Meta --}}
        <div class="flex items-center gap-4 text-sm text-gray-400 mb-6">
            <span><i class="far fa-calendar-alt mr-1"></i>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            <span><i class="far fa-user mr-1"></i>Utero Advertising</span>
            @if($post->category)
                <span><i class="far fa-folder mr-1"></i>{{ $post->category->name }}</span>
            @endif
        </div>

        {{-- Featured Image --}}
        @if($post->image)
            <div class="mb-6 rounded-card overflow-hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full" loading="eager">
            </div>
        @endif

        {{-- Content --}}
        <div class="isidesc">
            {!! cleanHtml($post->content) !!}
        </div>

        {{-- Share --}}
        <div class="mt-8 pt-6" style="border-top: 1px solid #E5E7EB;">
            <span class="text-sm font-semibold mr-3" style="color: #374151;"><i class="fas fa-share-alt mr-1"></i>Share:</span>
            <a href="#" class="share-social" data-network="facebook" title="Share on Facebook">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="share-social" data-network="twitter" title="Share on X (Twitter)">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="#000000" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
            </a>
            <a href="#" class="share-social" data-network="whatsapp" title="Share on WhatsApp">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="#25D366" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
            <a href="#" class="share-social" data-network="linkedin" title="Share on LinkedIn">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="#0A66C2" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/></svg>
            </a>
        </div>
    </div>

    {{-- Related Posts --}}
    @if(isset($relatedPosts) && $relatedPosts->count())
        <div class="content-card mt-4">
            <div class="section-label"><i class="fas fa-link mr-2 text-brand"></i>Berita Terkait</div>
            <div class="space-y-3">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related->slug) }}" class="block no-underline group">
                        <div class="flex items-center gap-4 p-3 rounded-lg transition-all" style="border: 1px solid #F3F4F6;">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-20 h-14 object-cover rounded-lg" loading="lazy">
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold truncate group-hover:text-brand transition-colors" style="color: #000000;">{{ $related->title }}</h4>
                                <span class="text-xs text-gray-400"><i class="far fa-calendar-alt mr-1"></i>{{ $related->published_at ? $related->published_at->format('M d, Y') : $related->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
