@extends('layouts.frontend')

@section('title', 'Produk | Utero Advertising')
@section('meta_description', 'Katalog produk Utero Advertising — banner, spanduk, neon box, huruf timbul, cutting sticker, dan produk periklanan lainnya.')
@section('meta_keywords', 'produk advertising, banner malang, spanduk, neon box, huruf timbul, cutting sticker, cetak printing')

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
        <div class="page-title">Katalog Produk</div>
        <div class="page-title-bar"></div>

        {{-- Search & Filter --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Kategori</label>
                    <select name="cat" onchange="this.form.submit()" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('cat') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Cari Produk</label>
                    <input type="text" name="src" value="{{ request('src') }}" placeholder="Ketik nama produk..." class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10"/>
                </div>
                <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white bg-brand hover:bg-brand-dark transition-colors">
                    <i class="fas fa-search mr-1"></i>Cari
                </button>
            </form>
        </div>

        {{-- Product Table --}}
        <div class="overflow-x-auto">
            <table class="product-table">
                <tr class="thead">
                    <td class="w-12">&nbsp;</td>
                    <td>Nama Produk</td>
                    <td class="text-center">Min. Order</td>
                    <td class="text-right">Harga Satuan</td>
                </tr>
                @forelse($products as $index => $product)
                    <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                        <td class="row-center">
                            @if($product->images->count())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="row-name">
                            <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                        </td>
                        <td class="row-center">{{ $product->min_order ?? 1 }}</td>
                        <td class="row-price">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-400">
                            <i class="fas fa-search text-2xl mb-2 block"></i>
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div class="flex justify-end mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
