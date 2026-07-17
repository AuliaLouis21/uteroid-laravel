@extends('layouts.frontend')

@section('title', $product->name . ' - Utero Group')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand">Beranda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('products.index') }}" class="hover:text-brand">Produk</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $product->name }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-12">

        {{-- Product Image --}}
        <div class="lg:w-1/2">
            <div class="bg-gray-200 rounded-xl aspect-square flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                @else
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                @endif
            </div>
            @if($product->images->count())
            <div class="grid grid-cols-4 gap-3 mt-4">
                @foreach($product->images->take(4) as $img)
                <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $img->image) }}" alt="" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="lg:w-1/2">
            @if($product->category)
            <span class="inline-block bg-brand-light text-brand text-xs font-medium px-3 py-1 rounded-full mb-3">{{ $product->category->name }}</span>
            @endif

            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

            <div class="text-2xl font-bold text-brand mb-6">Rp {{ number_format($product->unit_price, 0, ',', '.') }}</div>

            <div class="space-y-4 mb-8">
                <div class="grid grid-cols-2 gap-4">
                    @if($product->type)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <span class="text-sm text-gray-500">Tipe</span>
                        <p class="font-medium text-gray-900">{{ $product->type->name }}</p>
                    </div>
                    @endif

                    @if($product->size)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <span class="text-sm text-gray-500">Ukuran</span>
                        <p class="font-medium text-gray-900">{{ $product->size }}</p>
                    </div>
                    @endif

                    @if($product->thickness)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <span class="text-sm text-gray-500">Ketebalan</span>
                        <p class="font-medium text-gray-900">{{ $product->thickness }}</p>
                    </div>
                    @endif

                    @if($product->min_order)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <span class="text-sm text-gray-500">Minimal Order</span>
                        <p class="font-medium text-gray-900">{{ number_format($product->min_order) }} pcs</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($product->description)
            <div class="mb-8">
                <h2 class="font-semibold text-gray-900 mb-2">Deskripsi</h2>
                <div class="text-gray-600 leading-relaxed prose max-w-none">{!! $product->description !!}</div>
            </div>
            @endif

            <a href="{{ route('order.create') }}" class="inline-block w-full sm:w-auto text-center bg-brand text-white font-semibold px-8 py-3 rounded-lg hover:bg-brand-dark transition">
                Pesan Produk Ini
            </a>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <a href="{{ route('products.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
                <div class="aspect-video bg-gray-200 flex items-center justify-center">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 group-hover:text-brand transition line-clamp-2">{{ $related->name }}</h3>
                    <p class="text-brand font-bold mt-1 text-sm">Rp {{ number_format($related->unit_price, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection
