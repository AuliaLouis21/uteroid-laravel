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

            {{-- Perhitungan Jumlah Order --}}
            <div class="bg-gray-50 rounded-card p-5 mb-6 border border-gray-100">
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: #000000;">
                    <i class="fas fa-calculator mr-2 text-brand"></i>Perhitungan Jumlah Order
                </h3>

                @if($isPreselected)
                    {{-- Tampilan saat produk dipilih dari halaman produk --}}
                    <input type="hidden" name="items[0][product_id]" value="{{ $preselectedProduct->id }}">
                    <input type="hidden" name="items[0][product_name]" value="{{ $preselectedProduct->name }}">
                    <input type="hidden" name="items[0][size_unit]" value="{{ $preselectedProduct->size_unit }}">

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        {{-- Info Produk --}}
                        <div class="mb-4 pb-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">{{ $preselectedProduct->name }}</span>
                            <span class="text-xs text-gray-500 ml-2">
                                @if($preselectedProduct->size_unit === 'm2')
                                    Harga per m²: Rp. {{ number_format($preselectedProduct->unit_price) }}
                                @elseif($preselectedProduct->size_unit === 'cm2')
                                    Harga per Cm²: Rp. {{ number_format($preselectedProduct->unit_price) }}
                                @else
                                    Harga: Rp. {{ number_format($preselectedProduct->unit_price) }}
                                @endif
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Jumlah Order Dalam Cm²/m² --}}
                            <div class="form-group mb-0">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">
                                    Jumlah Order Dalam {{ $preselectedProduct->size_unit === 'm2' ? 'm²' : 'Cm²' }}
                                </label>
                                <input type="number" name="items[0][area]" x-model="area"
                                       min="{{ $preselectedProduct->min_order ?? 1 }}" step="any"
                                       @change="clampArea()"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand"
                                       placeholder="Masukkan jumlah dalam {{ $preselectedProduct->size_unit === 'm2' ? 'm²' : 'Cm²' }}" required>
                                <div class="text-[11px] text-gray-400 mt-1">Min: {{ $preselectedProduct->min_order ?? 1 }} {{ $preselectedProduct->size_unit === 'm2' ? 'm²' : 'Cm²' }}</div>
                            </div>

                            {{-- Total Harga Satuan --}}
                            <div class="form-group mb-0">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
                                <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg font-semibold"
                                     x-text="formatCurrency(unitTotal())">Rp. 0</div>
                                <input type="hidden" name="items[0][unit_total]" :value="unitTotal()">
                            </div>

                            {{-- Jumlah Order (Quantity) --}}
                            <div class="form-group mb-0">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order (Quantity)</label>
                                <input type="number" name="items[0][quantity]" x-model="quantity"
                                       min="1" @change="clampQuantity()"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                <div class="text-[11px] text-gray-400 mt-1">Min: 1</div>
                            </div>

                            {{-- Total Harga Keseluruhan --}}
                            <div class="form-group mb-0">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Keseluruhan</label>
                                <div class="px-3 py-2.5 text-sm font-bold text-brand bg-brand/5 border border-brand/20 rounded-lg"
                                     x-text="formatCurrency(grandTotal())">Rp. 0</div>
                                <input type="hidden" name="items[0][total_price]" :value="grandTotal()">
                            </div>
                        </div>
                    </div>

                @else
                    {{-- Tampilan normal (tanpa preselected) --}}
                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                {{-- Info Produk --}}
                                <div class="mb-3 pb-2 border-b border-gray-100 flex items-center gap-2">
                                    <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" @change="onProductChange(item, index)"
                                            class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-unit="{{ $product->unit_price }}" data-min="{{ $product->min_order }}" data-unit-type="{{ $product->size_unit }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" :name="'items[' + index + '][product_name]'" :value="item.product_name" required>
                                    <input type="hidden" :name="'items[' + index + '][size_unit]'" :value="item.size_unit" required>
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                            class="px-3 py-2 text-red-500 hover:text-red-700 text-sm transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Jumlah Order Dalam Cm²/m² --}}
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">
                                            Jumlah Order Dalam <span x-text="item.size_unit === 'm2' ? 'm²' : 'Cm²'">Cm²</span>
                                        </label>
                                        <input type="number" :name="'items[' + index + '][area]'" x-model="item.area"
                                               :min="getMinOrder(item.product_id)" step="any" @change="clampArea(item)"
                                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand"
                                               :placeholder="'Masukkan jumlah dalam ' + (item.size_unit === 'm2' ? 'm²' : 'Cm²')" required>
                                        <div class="text-[11px] text-gray-400 mt-1" x-text="'Min: ' + getMinOrder(item.product_id) + ' ' + (item.size_unit === 'm2' ? 'm²' : 'Cm²')"></div>
                                    </div>

                                    {{-- Total Harga Satuan --}}
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Satuan</label>
                                        <div class="px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg font-semibold"
                                             x-text="formatCurrency(unitTotalItem(item))">Rp. 0</div>
                                        <input type="hidden" :name="'items[' + index + '][unit_total]'" :value="unitTotalItem(item)">
                                    </div>

                                    {{-- Jumlah Order (Quantity) --}}
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Jumlah Order (Quantity)</label>
                                        <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity"
                                               min="1" @change="clampQuantity(item)"
                                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-brand" required>
                                        <div class="text-[11px] text-gray-400 mt-1">Min: 1</div>
                                    </div>

                                    {{-- Total Harga Keseluruhan --}}
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Total Harga Keseluruhan</label>
                                        <div class="px-3 py-2.5 text-sm font-bold text-brand bg-brand/5 border border-brand/20 rounded-lg"
                                             x-text="formatCurrency(grandTotalItem(item))">Rp. 0</div>
                                        <input type="hidden" :name="'items[' + index + '][total_price]'" :value="grandTotalItem(item)">
                                    </div>
                                </div>
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
var productSizeUnits = {
    @foreach($products as $p)
        {{ $p->id }}: '{{ $p->size_unit }}'{{ $loop->last ? '' : ',' }}
    @endforeach
};
function orderForm() {
    return {
        @if($isPreselected)
        area: {{ $preselectedProduct->min_order ?? 1 }},
        quantity: 1,
        preselectedPrice: {{ (float) $preselectedProduct->unit_price }},
        preselectedMinOrder: {{ (int) ($preselectedProduct->min_order ?? 1) }},
        preselectedSizeUnit: '{{ $preselectedProduct->size_unit }}',
        clampArea() {
            var a = parseFloat(this.area);
            if (!a || a < this.preselectedMinOrder) {
                this.area = this.preselectedMinOrder;
            }
        },
        clampQuantity() {
            var q = parseInt(this.quantity, 10);
            if (!q || q < 1) {
                this.quantity = 1;
            }
        },
        unitTotal() {
            return this.preselectedPrice * (parseFloat(this.area) || 0);
        },
        grandTotal() {
            return this.unitTotal() * (parseInt(this.quantity) || 0);
        },
        @else
        items: [{ product_id: '', product_name: '', size_unit: '', area: 1, quantity: 1 }],
        getProductName(id) {
            return productMap[id] || '';
        },
        getProductPrice(id) {
            return productPrices[id] || 0;
        },
        getMinOrder(id) {
            return productMinOrders[id] || 1;
        },
        getSizeUnit(id) {
            return productSizeUnits[id] || '';
        },
        onProductChange(item, index) {
            item.product_name = this.getProductName(item.product_id);
            item.size_unit = this.getSizeUnit(item.product_id);
            item.area = this.getMinOrder(item.product_id);
            item.quantity = 1;
        },
        clampArea(item) {
            var min = this.getMinOrder(item.product_id);
            var a = parseFloat(item.area);
            if (!a || a < min) {
                item.area = min;
            }
        },
        clampQuantity(item) {
            var q = parseInt(item.quantity, 10);
            if (!q || q < 1) {
                item.quantity = 1;
            }
        },
        addItem() {
            this.items.push({ product_id: '', product_name: '', size_unit: '', area: 1, quantity: 1 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        unitTotalItem(item) {
            return this.getProductPrice(item.product_id) * (parseFloat(item.area) || 0);
        },
        grandTotalItem(item) {
            return this.unitTotalItem(item) * (parseInt(item.quantity) || 0);
        },
        grandTotal() {
            return this.items.reduce((sum, item) => sum + this.grandTotalItem(item), 0);
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
