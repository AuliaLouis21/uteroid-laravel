@extends('layouts.frontend')

@section('title', 'Produk | Utero Advertising')

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
    <div style="display:block; clear:both; margin-bottom:10px; padding:8px!important; background-color:#333; border-radius:4px;">
        <form method="GET" action="{{ route('products.index') }}">
            <select name="cat" onchange="this.form.submit()" style="padding:4px; border:1px solid #CCC; border-radius:2px;">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('cat') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <span style="display:block; margin-top:8px;">
                <input type="text" name="src" value="{{ request('src') }}" placeholder="Cari produk..." style="width:250px; padding:4px; border:1px solid #CCC; border-radius:2px;"/>
                <input type="submit" value="CARI" style="padding:4px 8px; cursor:pointer;"/>
            </span>
        </form>
    </div>

    <table class="product-table">
        <tr class="thead">
            <td style="width:36px;">&nbsp;</td>
            <td style="width:180px;">Nama Produk</td>
            <td>Min. Order</td>
            <td style="width:90px;">Harga Satuan</td>
        </tr>
        @forelse($products as $index => $product)
            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                <td class="row-center">
                    @if($product->images->count())
                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" style="width:30px; height:30px; object-fit:cover;">
                    @else
                        <div class="bg-gray-200 w-8 h-8 flex items-center justify-center text-gray-400 text-xs">N/A</div>
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
                <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada produk ditemukan.</td>
            </tr>
        @endforelse
    </table>

    <div class="text-right">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
