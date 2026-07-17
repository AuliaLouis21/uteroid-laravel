@extends('layouts.frontend')

@section('title', 'Pesan Produk')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Pesan Produk</h1>
            <p class="mt-2 text-gray-600">Isi form berikut untuk melakukan pemesanan</p>
        </div>

        <form action="{{ route('order.store') }}" method="POST" x-data="orderForm()">
            @csrf

            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pelanggan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('phone') border-red-500 @enderror"
                            required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('city') border-red-500 @enderror"
                            required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('postal_code') border-red-500 @enderror"
                            required>
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('address') border-red-500 @enderror"
                            required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan <span class="text-gray-400">(opsional)</span></label>
                        <textarea name="message" id="message" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Item Pesanan</h2>
                    <button type="button" @click="addItem()"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded-md transition">
                        + Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="flex flex-col sm:flex-row gap-4 mb-4 p-4 bg-gray-50 rounded-md">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                            <select :name="'items['+index+'][product_id]'"
                                x-model="item.product_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand"
                                required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-32">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" :name="'items['+index+'][quantity]'"
                                x-model="item.quantity" min="1" value="1"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand"
                                required>
                        </div>
                        <div class="flex items-end">
                            <button type="button" @click="removeItem(index)"
                                class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md transition text-sm font-semibold"
                                :disabled="items.length === 1"
                                :class="{ 'opacity-50 cursor-not-allowed': items.length === 1 }">
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>

                @error('items')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white font-semibold py-3 px-8 rounded-md transition text-lg">
                        Kirim Pesanan
                    </button>
                </div>
            </div>
        </form>

    </div>
</section>
@endsection

@push('scripts')
<script>
    function orderForm() {
        return {
            items: [
                { product_id: '', quantity: 1 }
            ],
            addItem() {
                this.items.push({ product_id: '', quantity: 1 });
            },
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            }
        }
    }
</script>
@endpush
