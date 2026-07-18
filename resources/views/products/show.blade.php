@extends('layouts.frontend')

@section('title', $product->name . ' | Utero Advertising')

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
            {{ $product->name }}
        </h1>

        <div class="flex gap-4 mb-4">
            <div class="flex-shrink-0">
                @if($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" style="max-width:200px; border:1px solid #CCC;">
                @endif
            </div>
            <div>
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF; width:100px;">Kategori</td>
                        <td style="padding:4px;">{{ $product->category->name ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF;">Harga</td>
                        <td style="padding:4px; color:#F00; font-weight:bold;">Rp. {{ number_format($product->price, 0, ',', '.') }},-</td>
                    </tr>
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF;">Ukuran</td>
                        <td style="padding:4px;">{{ $product->size ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF;">Min. Order</td>
                        <td style="padding:4px;">{{ $product->min_order ?? 1 }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF;">Ketebalan</td>
                        <td style="padding:4px;">{{ $product->thickness ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($product->description)
            <div class="isidesc">{!! $product->description !!}</div>
        @endif

        @if($product->images->count() > 1)
            <div class="mt-4">
                <strong>Gambar Lainnya:</strong>
                <div class="flex gap-2 mt-2">
                    @foreach($product->images->skip(1) as $img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }}" style="width:80px; height:80px; object-fit:cover; border:1px solid #CCC;">
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if($relatedProducts->count())
        <div class="detail-section mt-4" style="border-top:1px solid #999; padding-top:8px;">
            <strong>Produk Terkait:</strong>
            <div class="flex gap-2 mt-2">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="block" style="width:120px;">
                        @if($related->images->count())
                            <img src="{{ asset('storage/' . $related->images->first()->path) }}" alt="{{ $related->name }}" style="width:120px; height:90px; object-fit:cover; border:1px solid #CCC;">
                        @endif
                        <span class="block text-xs mt-1">{{ strtoupper($related->name) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
