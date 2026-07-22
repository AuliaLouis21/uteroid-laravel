@extends('layouts.frontend')

@section('title', $product->name . ' | Utero Advertising')
@section('meta_description', strip_tags(substr($product->description ?? $product->name, 0, 160)))
@section('og_type', 'product')

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
        <div class="page-title">{{ $product->name }}</div>
        <div class="page-title-bar"></div>

        <div class="flex flex-col md:flex-row gap-6 mb-6">
            {{-- Product Image --}}
            <div class="flex-shrink-0">
                @if($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full md:w-64 rounded-card shadow-card" loading="lazy">
                @endif
            </div>

            {{-- Product Info --}}
            <div class="flex-1 min-w-0">
                <table class="w-full">
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 bg-gray-50 w-36 text-sm font-medium text-gray-600">Kategori</td>
                        <td class="py-3 px-4 text-sm">{{ $product->category?->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 bg-gray-50 text-sm font-medium text-gray-600">Harga</td>
                        <td class="py-3 px-4 text-sm font-bold text-brand">Rp. {{ number_format($product->price, 0, ',', '.') }},-</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 bg-gray-50 text-sm font-medium text-gray-600">Ukuran</td>
                        <td class="py-3 px-4 text-sm">{{ $product->size ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 bg-gray-50 text-sm font-medium text-gray-600">Min. Order</td>
                        <td class="py-3 px-4 text-sm">{{ $product->min_order ?? 1 }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-4 bg-gray-50 text-sm font-medium text-gray-600">Ketebalan</td>
                        <td class="py-3 px-4 text-sm">{{ $product->thickness ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Description --}}
        @if($product->description)
            <div class="isidesc mt-6">
                <h3 class="text-lg font-semibold mb-3">Deskripsi Produk</h3>
                {!! cleanHtml($product->description) !!}
            </div>
        @endif

        {{-- Additional Images --}}
        @if($product->images->count() > 1)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-3">Gambar Lainnya</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($product->images->skip(1) as $img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 hover:shadow-card transition-shadow" loading="lazy">
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-6 flex gap-3">
            <a href="{{ route('order.create') }}" class="form-submit">
                <i class="fas fa-paper-plane"></i>Pesan Sekarang
            </a>
            <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-lg text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors no-underline">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
        <div class="content-card">
            <div class="section-label"><i class="fas fa-link mr-2 text-brand"></i>Produk Terkait</div>
            <div class="product-grid">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="product-grid-item no-underline">
                        @if($related->images->count())
                            <img src="{{ asset('storage/' . $related->images->first()->path) }}" alt="{{ $related->name }}" loading="lazy">
                        @endif
                        <div class="prodtitle">
                            <a href="{{ route('products.show', $related->slug) }}">{{ strtoupper($related->name) }}</a>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
