@extends('layouts.frontend')

@section('title', 'Berita | Utero Advertising')
@section('meta_description', 'Berita terkini seputar Utero Advertising, produk, promo, dan tips periklanan di Malang.')
@section('meta_keywords', 'berita advertising, berita utero, promo printing, tips periklanan malang')

@section('sidebar-left')
<div class="sidebar-left">
    <div class="label-title">Product Category</div>
    <div class="sidebar-left-scroll">
        <ul class="category-list">
            @foreach($categories as $cat)
                <li><a href="{{ route('products.category', $cat->slug) }}" title="category: {{ $cat->name }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="detail-section">
        <h1 style="border-bottom:1px solid #999; padding-bottom:4px; margin-bottom:8px;">
            Berita Terkini
        </h1>
    </div>

    @if(request('src'))
        <div class="mb-2 p-2 bg-gray-100 text-sm">
            Pencarian: "<strong>{{ request('src') }}</strong>"
            <a href="{{ route('posts.index') }}" class="text-utero-link ml-2">Reset</a>
        </div>
    @endif

    @forelse($posts as $post)
        <div style="display:block; clear:both; padding:6px 2px; border-bottom:1px solid #EFEFEF; border-top:1px solid #FFF;">
            <div>
                <a href="{{ route('posts.show', $post->slug) }}" style="font:bold 16px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif; color:#333; letter-spacing:-1px; text-decoration:none;">
                    {{ $post->title }}
                </a>
            </div>
            <span style="display:block; font:normal 11px/100% Verdana, Geneva, sans-serif; letter-spacing:-1px; color:#CCC;">
                {{ $post->published_at ? $post->published_at->format('F jS, Y') : $post->created_at->format('F jS, Y') }}
            </span>
            <div style="font:normal 12px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif; margin-top:4px;">
                {{ strip_tags(substr($post->content, 0, 200)) }} ...
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center py-8">Belum ada berita.</p>
    @endforelse

    <div class="text-right mt-4">
        {{ $posts->withQueryString()->links() }}
    </div>
</div>
@endsection
