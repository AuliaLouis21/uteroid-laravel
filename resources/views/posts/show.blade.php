@extends('layouts.frontend')

@section('title', $post->title . ' | Berita | Utero Advertising')
@section('meta_description', strip_tags(substr($post->excerpt ?: strip_tags($post->content), 0, 160)))
@section('og_type', 'article')

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
        <a href="{{ route('posts.index') }}" class="text-sm text-brand no-underline hover:text-white mb-4 inline-block">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Berita
        </a>
        <div class="page-title">{{ $post->title }}</div>
        <div class="page-title-bar"></div>
        <span class="text-sm text-gray-400 block mb-6">
            <i class="far fa-clock mr-1"></i>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}
        </span>

        @if($post->image)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full rounded-card shadow-card" loading="lazy">
            </div>
        @endif

        <div class="isidesc">{!! cleanHtml($post->content) !!}</div>
    </div>

    @if(isset($relatedPosts) && $relatedPosts->count())
        <div class="content-card">
            <div class="section-label"><i class="fas fa-link mr-2 text-brand"></i>Berita Terkait</div>
            <div class="space-y-3">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related->slug) }}" class="block no-underline group">
                        <div class="border border-gray-100 rounded-lg p-4 hover:shadow-card transition-all duration-200 hover:border-brand/20">
                            <h4 class="font-semibold text-sm group-hover:text-brand transition-colors" style="color: #000000;">{{ $related->title }}</h4>
                            <span class="text-xs text-gray-400">
                                <i class="far fa-clock mr-1"></i>{{ $related->published_at ? $related->published_at->format('M d, Y') : $related->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
