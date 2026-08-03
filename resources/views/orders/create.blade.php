@extends('layouts.frontend')

@section('title', 'Pesan Produk | Utero Advertising')

@php
    $isPreselected = isset($preselectedProduct) && $preselectedProduct;
@endphp

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
<div class="main-content" x-data="orderForm()">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-shopping-cart mr-2"></i>Formulir Pemesanan</div>
        <div class="page-title-bar"></div>

        <form method="POST" action="{{ route('order.store') }}">
            @csrf

            {{-- Data Pemesan --}}
            <div class="bg-gray-50 rounded-card p-5 mb-6 border border-gray-100">
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: #000000;">
                    <i class="fas fa-user mr-2 text-brand"></i>Data Pemesan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group mb-0">
                        <label for="name">Nama Lengkap <span class="text-brand">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama" required>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label for="email">Email <span class="text-brand">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group mb-0">
                        <label for="phone">Telepon <span class="text-brand">*</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Nomor telepon" required>
                    </div>
                    <div class="form-group mb-0">
                        <label for="city">Kota</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="Kota asal">
                    </div>
                    <div class="form-group mb-0 md:col-span-2">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" rows="2" placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group mb-0 md:col-span-2">
                        <label for="message">Pesan</label>
                        <textarea name="message" id="message" rows="3" placeholder="Tulis pesan atau catatan...">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Produk yang Dipesan --}}
            <div class="bg-gray-50 rounded-card p-5 mb-6 border border-gray-100">
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: #000000;">
                    <i class="fas fa-box mr-2 text-brand"></i>Produk yang Dipesan
                </h3>

                @if($isPreselected)
                    {{-- Tampilan saat produk dipilih dari halaman produk --}}
                    <input type="hidden" name="items[0][product_id]" value="{{ $preselectedProduct->id }}">
                    <input type="hidden" name="items[0][product_name]" value="{{ $preselectedProduct->name }}">

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <div class="flex flex-wrap items-end gap-4">
                            {{-- Produk (locked) --}}
                            <div class="flex-1 min-w-[200px]">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Produk</label>
                                <div class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-100 text-gray-700">
                                    {{ $preselectedProduct->name }} - Rp. {{ number_format($preselectedProduct->unit_price) }}
                                    @if($preselectedProduct->size_unit === 'm2')
                                        <span class="text-gray-500">(m²)</span>
                                    @elseif($preselectedProduct->size_unit === 'cm2')
                                        <span class="text-gray-500">(Cm²)</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Total Harga Satuan --}}
                            <div class="w-36">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
                                <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg">
                                    Rp. {{ number_format($preselectedProduct->unit_price) }}
                                </div>
                            </div>

                            {{-- Jumlah Order --}}
                            <div class="w-28">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order</label>
                                <input type="number" name="items[0][quantity]" x-model="quantity"
                                       min="{{ $preselectedProduct->min_order ?? 1 }}" @change="clampQuantity()"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                <div class="text-[11px] text-gray-400 mt-1">Min: {{ $preselectedProduct->min_order ?? 1 }}</div>
                            </div>

                            {{-- Total Harga Keseluruhan --}}
                            <div class="w-40">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Keseluruhan</label>
                                <div class="px-3 py-2.5 text-sm font-semibold text-brand bg-brand/5 border border-brand/20 rounded-lg" x-text="formatCurrency(lineTotal())">Rp. 0</div>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- Tampilan normal (tanpa preselected) --}}
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex flex-wrap items-end gap-3 bg-white p-4 rounded-lg border border-gray-200">
                                <div class="flex-1 min-w-[200px]">
                                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Produk</label>
                                    <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" @change="onProductChange(item)" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} - Rp. {{ number_format($product->price) }}{{ $product->size_unit === 'm2' ? ' (m²)' : ($product->size_unit === 'cm2' ? ' (Cm²)' : '') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" :name="'items[' + index + '][product_name]'" :value="item.product_name" required>

                                <div class="w-36">
                                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
                                    <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg" x-text="formatCurrency(getProductPrice(item.product_id))">Rp. 0</div>
                                </div>
                                <div class="w-28">
                                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order</label>
                                    <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" :min="getMinOrder(item.product_id)" @change="clampQuantity(item)" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                    <div class="text-[11px] text-gray-400 mt-1" x-text="'Min: ' + getMinOrder(item.product_id)"></div>
                                </div>
                                <div class="w-40">
                                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Keseluruhan</label>
                                    <div class="px-3 py-2.5 text-sm font-semibold text-brand bg-brand/5 border border-brand/20 rounded-lg" x-text="formatCurrency(lineTotalItem(item))">Rp. 0</div>
                                </div>
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="px-3 py-2.5 text-red-500 hover:text-red-700 text-sm transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addItem()" class="mt-4 px-4 py-2.5 rounded-lg text-sm font-semibold text-brand bg-brand/10 hover:bg-brand/20 transition-colors">
                        <i class="fas fa-plus mr-1"></i>Tambah Produk
                    </button>
                @endif
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-between gap-4 bg-white p-4 rounded-lg border border-gray-200 mb-4">
                <div>
                    <span class="text-sm font-semibold text-gray-500">Total Pesanan</span>
                    <div class="text-2xl font-bold text-brand" x-text="formatCurrency(grandTotal())">Rp. 0</div>
                </div>
                <div class="flex justify-end">
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-order">
                    <button type="submit" class="form-submit">
                        <i class="fas fa-paper-plane"></i>Kirim Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
var productMap = {
    @foreach($products as $p)
        {{ $p->id }}: @json($p->name){{ $loop->last ? '' : ',' }}
    @endforeach
};
var productPrices = {
    @foreach($products as $p)
        {{ $p->id }}: {{ (float) $p->unit_price }}{{ $loop->last ? '' : ',' }}
    @endforeach
};
var productMinOrders = {
    @foreach($products as $p)
        {{ $p->id }}: {{ (int) $p->min_order }}{{ $loop->last ? '' : ',' }}
    @endforeach
};
function orderForm() {
    return {
        @if($isPreselected)
        quantity: {{ $preselectedProduct->min_order ?? 1 }},
        preselectedPrice: {{ (float) $preselectedProduct->unit_price }},
        preselectedMinOrder: {{ (int) ($preselectedProduct->min_order ?? 1) }},
        clampQuantity() {
            var q = parseInt(this.quantity, 10);
            if (!q || q < this.preselectedMinOrder) {
                this.quantity = this.preselectedMinOrder;
            }
        },
        lineTotal() {
            return this.preselectedPrice * (parseInt(this.quantity) || 0);
        },
        grandTotal() {
            return this.lineTotal();
        },
        @else
        items: [{ product_id: '', product_name: '', quantity: 1 }],
        getProductName(id) {
            return productMap[id] || '';
        },
        getProductPrice(id) {
            return productPrices[id] || 0;
        },
        getMinOrder(id) {
            return productMinOrders[id] || 1;
        },
        onProductChange(item) {
            item.product_name = this.getProductName(item.product_id);
            item.quantity = this.getMinOrder(item.product_id);
        },
        clampQuantity(item) {
            var min = this.getMinOrder(item.product_id);
            var q = parseInt(item.quantity, 10);
            if (!q || q < min) {
                item.quantity = min;
            }
        },
        addItem() {
            this.items.push({ product_id: '', product_name: '', quantity: 1 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        lineTotalItem(item) {
            return this.getProductPrice(item.product_id) * (parseInt(item.quantity) || 0);
        },
        grandTotal() {
            return this.items.reduce((sum, item) => sum + this.lineTotalItem(item), 0);
        },
        @endif
        formatCurrency(value) {
            return 'Rp. ' + Number(value || 0).toLocaleString('id-ID');
        }
    }
}
</script>
@php $recaptchaSiteKey = config('recaptcha.site_key'); @endphp
@if($recaptchaSiteKey)
<script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}" async></script>
<script>
var orderStoreUrl = @json(route('order.store'));
document.querySelector('form[action="' + orderStoreUrl + '"]').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ $recaptchaSiteKey }}', {action: 'order'}).then(function(token) {
            document.getElementById('g-recaptcha-response-order').value = token;
            form.submit();
        });
    });
});
</script>
@endif
@endpush
@endsection
