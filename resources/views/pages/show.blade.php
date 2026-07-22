@extends('layouts.frontend')

@section('title', $page->title . ' | Utero Advertising')
@section('meta_description', strip_tags(substr($page->content, 0, 160)))

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
            {{ $page->title }}
        </h1>
        <div class="isidesc">{!! cleanHtml($page->content) !!}</div>
    </div>
</div>
@endsection
