@extends('layouts.frontend')

@section('title', 'Pesan Produk | Utero Advertising')

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
<div class="main-content" x-data="orderForm()">
    <div class="detail-section">
        <h1 style="border-bottom:1px solid #999; padding-bottom:4px; margin-bottom:8px;">
            Formulir Pemesanan
        </h1>
    </div>

    <form method="POST" action="{{ route('order.store') }}">
        @csrf
        <div class="detail-section">
            <div style="background:#222; border:2px solid #222; color:#FFF; padding:12px 4px; text-align:center; font:bold 14px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                Data Pemesan
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Nama Lengkap</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" style="width:236px;" required>
                    @error('customer_name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Email</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <input type="email" name="email" value="{{ old('email') }}" style="width:236px;" required>
                </div>
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Telepon</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <input type="tel" name="phone" value="{{ old('phone') }}" style="width:236px;" required>
                </div>
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Kota</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <input type="text" name="city" value="{{ old('city') }}" style="width:236px;">
                </div>
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Alamat</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <textarea name="address" style="width:236px; height:60px;">{{ old('address') }}</textarea>
                </div>
            </div>
            <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333;">
                <div style="width:130px; padding:8px 4px 6px 4px; color:#FFF; background:#222;">Pesan</div>
                <div style="padding:6px 0 2px 0; flex:1;">
                    <textarea name="notes" style="width:236px; height:60px;">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="detail-section mt-2">
            <div style="background:#222; border:2px solid #222; color:#FFF; padding:12px 4px; text-align:center; font:bold 14px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                Produk yang Dipesan
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div style="display:flex; flex-wrap:wrap; border-bottom:1px solid #111; border-top:1px solid #333; padding:4px;">
                    <select :name="'items[' + index + '][product_id]'" style="flex:1; margin-right:8px;" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - Rp. {{ number_format($product->price) }}</option>
                        @endforeach
                    </select>
                    <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" min="1" value="1" style="width:60px;" required>
                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="ml-2 text-red-500 text-xs">Hapus</button>
                </div>
            </template>

            <div style="margin-top:8px;">
                <button type="button" @click="addItem()" style="background:#09F; color:#FFF; border:none; padding:4px 8px; cursor:pointer; font-size:12px;">
                    + Tambah Produk
                </button>
            </div>
        </div>

        <div style="margin-top:8px; text-align:right;">
            <button type="submit" style="background:url(/images/bg-footer.png) 0px -23px repeat-x #CCC; border:1px solid #333; padding:4px 16px; cursor:pointer; font:normal 12px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                Kirim Pesanan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function orderForm() {
    return {
        items: [{ product_id: '', quantity: 1 }],
        addItem() {
            this.items.push({ product_id: '', quantity: 1 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>
@endpush
@endsection
