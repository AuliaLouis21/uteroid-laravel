@extends('layouts.frontend')

@section('title', 'Utero Advertising | Idea And Concept Factory')

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
    <div id="boxpromo" class="promo-slider">
        @if($promoProducts->count())
            <div x-data="slider()" x-init="init()" class="relative w-full h-full">
                <template x-for="(product, index) in products" :key="product.id">
                    <div x-show="current === index"
                         x-transition:enter="transition ease-in-out duration-500"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in-out duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="promo-slide absolute inset-0">
                        <template x-if="product.images && product.images.length">
                            <div class="w-full h-full bg-cover bg-center" :style="'background-image:url(' + '/storage/' + product.images[0].path + ')'"></div>
                        </template>
                        <div class="promo-slide-meta">
                            <span class="promo-slide-title">
                                <a :href="'/produk/' + product.slug" :title="product.name" x-text="product.name + ' →'"></a>
                            </span>
                            <span class="promo-slide-spec">
                                Ukuran: <span x-text="product.size || '-'"></span> | Harga Satuan: <b x-text="'Rp. ' + formatPrice(product.price) + ',-'"></b>
                            </span>
                        </div>
                    </div>
                </template>

                <div class="promo-slider-arrow prev" @@click="prev()">&#8249;</div>
                <div class="promo-slider-arrow next" @@click="next()">&#8250;</div>

                <div class="promo-slider-dots">
                    <template x-for="(product, index) in products" :key="index">
                        <span :class="{ active: current === index }" @@click="current = index"></span>
                    </template>
                </div>
            </div>
        @else
            <div class="promo-slide flex items-center justify-center text-gray-400">
                <span>Belum ada produk promo</span>
            </div>
        @endif
    </div>

    <div class="label-title" style="margin-bottom:8px;">produk terbaru</div>
    @php $x = 0; @endphp
    @foreach($latestProducts as $product)
        @php
            $x++;
            $margin = ($x % 3 == 0) ? 'margin-right:0px;' : 'margin-right:8px;';
        @endphp
        <div class="product-grid-item" style="{{ $margin }}">
            <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->name }}">
                @if($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                @else
                    <div class="bg-gray-200 h-24 flex items-center justify-center text-gray-400 text-xs">No Image</div>
                @endif
            </a>
            <span class="prodtitle"><a href="{{ route('products.show', $product->slug) }}" title="{{ $product->name }}">{{ strtoupper($product->name) }}</a></span>
            <span class="prodprice">Rp. {{ number_format($product->price, 0, ',', '.') }},-</span>
        </div>
    @endforeach
    <span class="section-divider"><a href="{{ route('products.index') }}" title="All Product">...See All Product &raquo;</a></span>
</div>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    @foreach($latestNews as $news)
        <div class="sidebar-right-news">
            <a target="_blank" href="{{ route('posts.show', $news->slug) }}">{{ ucwords($news->title) }}</a>
            {{ strip_tags(substr($news->content, 0, 150)) }} ...
        </div>
    @endforeach
    @foreach($advertisements as $ad)
        <div class="sidebar-right-ads">
            <a href="{{ $ad->link ?? '#' }}" title="{{ $ad->title }}" target="_blank">
                @if($ad->image)
                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}">
                @endif
            </a>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
function slider() {
    return {
        products: @json($promoProducts),
        current: 0,
        timer: null,
        init() {
            this.start();
        },
        start() {
            if (this.timer) clearInterval(this.timer);
            this.timer = setInterval(() => {
                this.current = (this.current + 1) % this.products.length;
            }, 5000);
        },
        prev() {
            this.current = (this.current - 1 + this.products.length) % this.products.length;
            this.start();
        },
        next() {
            this.current = (this.current + 1) % this.products.length;
            this.start();
        },
        formatPrice(val) {
            return new Intl.NumberFormat('id-ID').format(val);
        }
    }
}
</script>
@endpush
