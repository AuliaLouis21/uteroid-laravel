@extends('layouts.frontend')

@section('title', 'News | Utero Advertising')
@section('meta_description', 'Berita terkini seputar Utero Advertising, produk, promo, dan tips periklanan di Malang.')

@section('sidebar-left')
<div class="sidebar-left">
    {{-- Search --}}
    <div class="sidebar-card">
        <div class="card-header">
            <i class="fas fa-search"></i>Cari Berita
        </div>
        <div class="p-4">
            <form action="{{ route('posts.index') }}" method="GET" class="flex">
                <input type="text" name="src" placeholder="Ketik kata kunci..." value="{{ request('src') }}" class="flex-1 min-w-0 px-3 py-2 text-sm border border-gray-200 border-r-0 rounded-l-lg focus:outline-none focus:border-brand">
                <button type="submit" class="px-4 py-2 bg-brand text-white border-none rounded-r-lg hover:bg-brand-dark transition-colors">
                    <i class="fas fa-arrow-right"></i>
                </button>
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
        <div class="page-title"><i class="fas fa-newspaper mr-2 text-brand"></i>Berita Terkini</div>
        <div class="page-title-bar"></div>

        @if(request('src'))
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px;">
                <i class="fas fa-search mr-1"></i>Pencarian: "<strong>{{ request('src') }}</strong>"
                <a href="{{ route('posts.index') }}" style="color: #ce181e; margin-left: 8px; font-weight: 500;">Reset</a>
            </div>
        @endif

        @if($posts->count())
            <div class="space-y-4">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="block no-underline group">
                        <div style="background: #fff; border: 1px solid #F3F4F6; border-radius: 12px; padding: 20px; transition: all 0.3s ease;">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-2">
                                <span><i class="far fa-calendar-alt mr-1"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                @if($post->category)
                                    <span><i class="far fa-folder mr-1"></i>{{ $post->category->name }}</span>
                                @endif
                            </div>
                            <h3 class="text-base font-semibold mb-1 group-hover:text-brand transition-colors" style="color: #000000;">
                                {{ $post->title }}
                            </h3>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ strip_tags(substr($post->excerpt ?: $post->content, 0, 200)) }}...</p>
                            <span class="inline-flex items-center gap-1 text-sm font-medium mt-3" style="color: #ce181e;">
                                Read More <i class="fas fa-arrow-right text-xs"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-end mt-6">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-newspaper text-3xl mb-3 block"></i>
                Belum ada berita.
            </div>
        @endif
    </div>
</div>
@endsection
