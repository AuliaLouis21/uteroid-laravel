@extends('layouts.frontend')

@section('title', 'Utero Group - Solusi Packaging & Printing Berkualitas')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-brand to-brand-dark text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Solusi Packaging & Printing Berkualitas
            </h1>
            <p class="text-lg md:text-xl text-red-100 mb-8 max-w-2xl">
                Utero Group menyediakan produk packaging dan printing berkualitas tinggi untuk mendukung pertumbuhan bisnis Anda.
            </p>
            <a href="{{ route('order.create') }}" class="inline-block bg-white text-brand-dark font-semibold px-8 py-3 rounded-lg hover:bg-brand-light transition">
                Pesan Sekarang
            </a>
        </div>
    </div>
</section>

{{-- Promo Products Section --}}
@if($promoProducts->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Produk Promo</h2>
        <a href="{{ route('products.index') }}" class="text-brand hover:text-brand-dark font-medium text-sm">Lihat Semua &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($promoProducts as $product)
        <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
            <div class="aspect-video bg-gray-200 flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                @endif
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 group-hover:text-brand transition">{{ $product->name }}</h3>
                <p class="text-brand font-bold mt-1">Rp {{ number_format($product->unit_price, 0, ',', '.') }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Latest News Section --}}
@if($latestNews->count())
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Berita Terbaru</h2>
            <a href="{{ route('posts.index') }}" class="text-brand hover:text-brand-dark font-medium text-sm">Lihat Semua &rarr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestNews as $news)
            <a href="{{ route('posts.show', $news->slug) }}" class="bg-gray-50 rounded-xl overflow-hidden group hover:shadow-md transition">
                <div class="aspect-video bg-gray-200 flex items-center justify-center">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 mb-1">{{ $news->created_at->format('d M Y') }}</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-brand transition line-clamp-2">{{ $news->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit(strip_tags($news->content ?? ''), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Gallery Preview Section --}}
@if($latestGalleries->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Galeri Kami</h2>
        <a href="{{ route('gallery.index') }}" class="text-brand hover:text-brand-dark font-medium text-sm">Lihat Semua &rarr;</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($latestGalleries as $gallery)
        <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden flex items-center justify-center">
            @if($gallery->image ?? $gallery->thumbnail ?? false)
                <img src="{{ asset('storage/' . ($gallery->image ?? $gallery->thumbnail)) }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-full h-full object-cover">
            @else
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Stats Section --}}
<section class="bg-brand text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl md:text-4xl font-bold">1000+</div>
                <div class="text-red-200 mt-1">Produk</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold">500+</div>
                <div class="text-red-200 mt-1">Klien</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold">10+</div>
                <div class="text-red-200 mt-1">Tahun Pengalaman</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold">24/7</div>
                <div class="text-red-200 mt-1">Layanan</div>
            </div>
        </div>
    </div>
</section>

@endsection
