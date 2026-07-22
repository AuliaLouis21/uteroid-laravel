@extends('layouts.frontend')

@section('title', $page->title . ' | Utero Advertising')
@section('meta_description', strip_tags(substr($page->content, 0, 160)))

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
        <div class="page-title">{{ $page->title }}</div>
        <div class="page-title-bar"></div>
        <div class="isidesc">{!! cleanHtml($page->content) !!}</div>
    </div>
</div>
@endsection
