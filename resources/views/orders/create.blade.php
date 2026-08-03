@extends('layouts.frontend')

@section('title', 'Pesan Produk | Utero Advertising')

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

                            {{-- Perhitungan Jumlah Order: luas (hanya jika produk memiliki ukuran) --}}
                            <template x-if="hasSize(item)">
                                <div>
                                    <div class="w-28">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Panjang (cm)</label>
                                        <input type="number" :name="'items[' + index + '][length_cm]'" x-model="item.length_cm" min="0" step="0.01" placeholder="cth: 120" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand">
                                    </div>
                                    <div class="w-28 mt-3">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Lebar (cm)</label>
                                        <input type="number" :name="'items[' + index + '][width_cm]'" x-model="item.width_cm" min="0" step="0.01" placeholder="cth: 80" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand">
                                    </div>
                                </div>
                                <div class="w-36">
                                    <label class="text-xs font-semibold text-gray-500 mb-1 block" x-text="'Jumlah Order (' + unitLabel(item) + ')'">Jumlah Order (m²)</label>
                                    <div class="px-3 py-2.5 text-sm font-semibold text-brand bg-brand/5 border border-brand/20 rounded-lg" x-text="formatArea(item)">0</div>
                                </div>
                            </template>

                            <div class="w-36">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
                                <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg" x-text="formatCurrency(getProductPrice(item.product_id))">Rp. 0</div>
                            </div>
                            <div class="w-24">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order (Quantity)</label>
                                <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" :min="getMinOrder(item.product_id)" @change="clampQuantity(item)" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                <div class="text-[11px] text-gray-400 mt-1" x-text="'Min: ' + getMinOrder(item.product_id)"></div>
                            </div>
                            <div class="w-40">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Keseluruhan</label>
                                <div class="px-3 py-2.5 text-sm font-semibold text-brand bg-brand/5 border border-brand/20 rounded-lg" x-text="formatCurrency(lineTotal(item))">Rp. 0</div>
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
var productSizeUnits = {
    @foreach($products as $p)
        {{ $p->id }}: @json($p->size_unit){{ $loop->last ? '' : ',' }}
    @endforeach
};
var productMinOrders = {
    @foreach($products as $p)
        {{ $p->id }}: {{ (int) $p->min_order }}{{ $loop->last ? '' : ',' }}
    @endforeach
};
function orderForm() {
    return {
        items: [{ product_id: '', product_name: '', quantity: 1, length_cm: '', width_cm: '' }],
        getProductName(id) {
            return productMap[id] || '';
        },
        getProductPrice(id) {
            return productPrices[id] || 0;
        },
        getSizeUnit(id) {
            return productSizeUnits[id] || null;
        },
        getMinOrder(id) {
            return productMinOrders[id] || 1;
        },
        hasSize(item) {
            return !!this.getSizeUnit(item.product_id);
        },
        unitLabel(item) {
            return this.getSizeUnit(item.product_id) === 'm2' ? 'm²' : 'Cm²';
        },
        onProductChange(item) {
            item.product_name = this.getProductName(item.product_id);
            item.length_cm = '';
            item.width_cm = '';
            item.quantity = this.getMinOrder(item.product_id);
        },
        clampQuantity(item) {
            var min = this.getMinOrder(item.product_id);
            var q = parseInt(item.quantity, 10);
            if (!q || q < min) {
                item.quantity = min;
            }
        },
        itemArea(item) {
            var unit = this.getSizeUnit(item.product_id);
            if (!unit) return 0;
            var l = parseFloat(item.length_cm) || 0;
            var w = parseFloat(item.width_cm) || 0;
            var cm2 = l * w;
            return unit === 'm2' ? cm2 / 10000 : cm2;
        },
        formatArea(item) {
            if (!this.hasSize(item)) return '0';
            return Number(this.itemArea(item) || 0).toLocaleString('id-ID') + ' ' + this.unitLabel(item);
        },
        addItem() {
            this.items.push({ product_id: '', product_name: '', quantity: 1, length_cm: '', width_cm: '' });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        lineTotal(item) {
            return this.getProductPrice(item.product_id) * (parseInt(item.quantity) || 0);
        },
        grandTotal() {
            return this.items.reduce((sum, item) => sum + this.lineTotal(item), 0);
        },
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
