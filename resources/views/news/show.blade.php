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
            <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white no-underline mr-2" style="background: #1877F2;" data-network="facebook" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white no-underline mr-2" style="background: #1DA1F2;" data-network="twitter" title="Share on Twitter"><i class="fab fa-x-twitter"></i></a>
            <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white no-underline mr-2" style="background: #25D366;" data-network="whatsapp" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white no-underline" style="background: #0A66C2;" data-network="linkedin" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
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
