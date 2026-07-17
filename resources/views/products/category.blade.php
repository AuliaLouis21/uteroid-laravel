@extends('layouts.frontend')

@section('title', $category->name . ' - Utero Group')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        <p class="text-gray-600 mt-2">Menampilkan semua produk dalam kategori {{ $category->name }}.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar --}}
        <aside class="lg:w-64 shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                <h2 class="font-semibold text-gray-900 mb-4">Kategori</h2>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.category', $cat->slug) }}"
                            class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ $cat->id === $category->id ? 'bg-brand-light text-brand font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
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

            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-gray-500 text-lg">Belum ada produk dalam kategori ini.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
