@extends('layouts.frontend')

@section('title', $product->name . ' | Utero Advertising')
@section('meta_description', strip_tags(substr($product->description ?? $product->name, 0, 160)))
@section('og_type', 'product')

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

        <div style="display:flex; flex-wrap:wrap; gap:16px; margin-bottom:16px;">
            <div style="flex-shrink:0;">
                @if($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" style="max-width:200px; width:100%; border:1px solid #CCC;" loading="lazy">
                @endif
            </div>
            <div style="flex:1; min-width:200px;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #CCC;">
                        <td style="padding:4px; background:#EFEFEF; width:100px;">Kategori</td>
                        <td style="padding:4px;">{{ $product->category?->name ?? '-' }}</td>
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
            <div class="isidesc">{!! cleanHtml($product->description) !!}</div>
        @endif

        @if($product->images->count() > 1)
            <div class="mt-4">
                <strong>Gambar Lainnya:</strong>
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;">
                    @foreach($product->images->skip(1) as $img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }}" style="width:80px; height:80px; object-fit:cover; border:1px solid #CCC;" loading="lazy">
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if($relatedProducts->count())
        <div class="detail-section mt-4" style="border-top:1px solid #999; padding-top:8px;">
            <strong>Produk Terkait:</strong>
            <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="block" style="width:120px;">
                        @if($related->images->count())
                            <img src="{{ asset('storage/' . $related->images->first()->path) }}" alt="{{ $related->name }}" style="width:120px; height:90px; object-fit:cover; border:1px solid #CCC;" loading="lazy">
                        @endif
                        <span class="block text-xs mt-1">{{ strtoupper($related->name) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
