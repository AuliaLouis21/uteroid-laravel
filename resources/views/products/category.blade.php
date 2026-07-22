@extends('layouts.frontend')

@section('title', $category->name . ' | Utero Advertising')
@section('meta_description', 'Produk kategori ' . $category->name . ' dari Utero Advertising — Malang, Jawa Timur.')

@section('sidebar-left')
<div class="sidebar-left">
    <div class="label-title">Product Category</div>
    <div class="sidebar-left-scroll">
        <ul class="category-list">
            @foreach($categories as $cat)
                <li><a href="{{ route('products.category', $cat->slug) }}" title="category: {{ $cat->name }}" {{ $cat->id == $category->id ? 'style="color:#DF282A; padding-left:20px; background-color:#EFEFEF;"' : '' }}>{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="detail-section">
        <h1>{{ $category->name }} <span style="font-size:40px;">&raquo;</span></h1>
        @if($category->description)
            <p class="text-gray-600 mb-4">{{ $category->description }}</p>
        @endif
    </div>

    <div style="display:block; clear:both; margin-bottom:10px; padding:8px!important; background-color:#333; border-radius:4px;">
        <form method="GET" action="{{ route('products.category', $category->slug) }}">
            <span>
                <input type="text" name="src" value="{{ request('src') }}" placeholder="Cari dalam kategori..." style="max-width:250px; width:100%; padding:4px; border:1px solid #CCC; border-radius:2px;"/>
                <input type="submit" value="CARI" style="padding:4px 8px; cursor:pointer;"/>
            </span>
        </form>
    </div>

    <div class="overflow-x-auto">
    <table class="product-table">
        <tr class="thead">
            <td>&nbsp;</td>
            <td>Nama Produk</td>
            <td>Min. Order</td>
            <td>Harga Satuan</td>
        </tr>
        @forelse($products as $index => $product)
            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                <td class="row-center">
                    @if($product->images->count())
                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" style="width:30px; height:30px; object-fit:cover;">
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
                <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada produk dalam kategori ini.</td>
            </tr>
        @endforelse
    </table>
    </div>

    <div class="text-right">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
