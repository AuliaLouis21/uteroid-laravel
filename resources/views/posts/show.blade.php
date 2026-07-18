@extends('layouts.frontend')

@section('title', $post->title . ' | Berita | Utero Advertising')

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
            {{ $post->title }}
        </h1>
        <span style="display:block; font:normal 10px/100% Verdana, Geneva, sans-serif; letter-spacing:-1px; color:#CCC; margin-bottom:12px;">
            {{ $post->published_at ? $post->published_at->format('F jS, Y') : $post->created_at->format('F jS, Y') }}
        </span>

        @if($post->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width:100%; border:1px solid #CCC;">
            </div>
        @endif

        <div class="isidesc">{!! $post->content !!}</div>
    </div>

    @if(isset($relatedPosts) && $relatedPosts->count())
        <div class="detail-section mt-4" style="border-top:1px solid #999; padding-top:8px;">
            <strong>Berita Terkait:</strong>
            @foreach($relatedPosts as $related)
                <div style="display:block; clear:both; padding:6px 2px; border-bottom:1px solid #EFEFEF; border-top:1px solid #FFF;">
                    <a href="{{ route('posts.show', $related->slug) }}" style="font:bold 14px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif; color:#333; text-decoration:none;">
                        {{ $related->title }}
                    </a>
                    <span style="display:block; font:normal 10px/100% Verdana, Geneva, sans-serif; color:#CCC; letter-spacing:-1px;">
                        {{ $related->published_at ? $related->published_at->format('F jS, Y') : $related->created_at->format('F jS, Y') }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
