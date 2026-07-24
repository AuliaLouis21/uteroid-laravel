@extends('layouts.frontend')

@section('title', 'Utero Advertising | Idea And Concept Factory')
@section('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur. Solusi periklanan, cetak, dan desain kreatif untuk bisnis Anda.')
@section('meta_keywords', 'advertising malang, perusahaan advertising, utero advertising, printing, digital printing, creative agency, malang')

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
                            <i class="fas fa-chevron-right"></i>
                            {{ $cat->name }}
                            <span class="ml-auto text-xs text-gray-400">({{ $cat->products_count ?? 0 }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="sidebar-card mt-4">
        <div class="card-header">
            <i class="fas fa-bolt"></i>Quick Links
        </div>
        <ul class="category-list">
            <li><a href="{{ route('products.index') }}"><i class="fas fa-shopping-cart"></i>Price List</a></li>
            <li><a href="{{ route('download.index') }}"><i class="fas fa-download"></i>Download</a></li>
            <li><a href="{{ route('order.create') }}"><i class="fas fa-paper-plane"></i>Pesan Sekarang</a></li>
            <li><a href="{{ route('contact.index') }}"><i class="fas fa-envelope"></i>Hubungi Kami</a></li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    {{-- Promo Slider --}}
    <div class="promo-slider mb-4">
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
                        <div class="w-full h-full bg-cover bg-center" :style="imgStyle(product)"></div>
                        <div class="promo-slide-meta">
                            <span class="promo-slide-title">
                                <a :href="'/produk/' + product.slug" :title="product.name" x-text="product.name + ' →'"></a>
                            </span>
                            <span class="promo-slide-spec">
                                Ukuran: <span x-text="product.size || '-'"></span> | Harga: <b x-text="'Rp. ' + formatPrice(product.price) + ',-'"></b>
                            </span>
                        </div>
                    </div>
                </template>
            </div>
        @else
            <div class="promo-slide flex items-center justify-center text-gray-400">
                <span>Belum ada produk promo</span>
            </div>
        @endif
    </div>

    {{-- Latest Products --}}
    <div class="content-card">
        <div class="section-label"><i class="fas fa-box-open mr-2 text-brand"></i>Produk Terbaru</div>
        <div class="product-grid">
            @foreach($latestProducts as $product)
                <div class="product-grid-item">
                    <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->name }}">
                        @if($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="bg-gray-100 h-44 flex items-center justify-center text-gray-400 text-sm">
                                <i class="fas fa-image mr-2"></i>No Image
                            </div>
                        @endif
                    </a>
                    <div class="prodtitle">
                        <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->name }}">{{ strtoupper($product->name) }}</a>
                    </div>
                    <div class="prodprice">Rp. {{ number_format($product->price, 0, ',', '.') }},-</div>
                </div>
            @endforeach
        </div>
        <div class="section-divider mt-4">
            <a href="{{ route('products.index') }}" title="All Product">Lihat Semua Produk &raquo;</a>
        </div>
    </div>
</div>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    {{-- Latest News --}}
    <div class="news-card">
        <div class="card-header">
            <i class="fas fa-newspaper"></i>Berita Terbaru
        </div>
        @foreach($latestNews as $news)
            <a href="{{ route('posts.show', $news->slug) }}" class="news-item" target="_blank">
                <span class="news-title">{{ ucwords($news->title) }}</span>
                <span class="news-excerpt">{{ strip_tags(substr($news->content, 0, 100)) }}...</span>
                <span class="news-date"><i class="far fa-clock mr-1"></i>{{ $news->published_at ? $news->published_at->format('M d, Y') : $news->created_at->format('M d, Y') }}</span>
            </a>
        @endforeach
    </div>

    {{-- Advertisements --}}
    @if($advertisements->count())
        <div class="news-card">
            <div class="card-header">
                <i class="fas fa-bullhorn"></i>Promosi
            </div>
            @foreach($advertisements as $ad)
                <a href="{{ $ad->link ?? '#' }}" title="{{ $ad->title }}" target="_blank" class="ad-item block">
                    @if($ad->image)
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" loading="lazy">
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function slider() {
    return {
        products: @json($promoProducts),
        current: 0,
        init() {
            setInterval(() => {
                this.current = (this.current + 1) % this.products.length;
            }, 4000);
        },
        imgStyle(product) {
            var src = product.image || (product.images && product.images[0] ? product.images[0].path : null);
            return src ? 'background-image:url(' + '/storage/' + src + ')' : 'background-color:#000000';
        },
        formatPrice(val) {
            return new Intl.NumberFormat('id-ID').format(val);
        }
    }
}
</script>
@endpush
