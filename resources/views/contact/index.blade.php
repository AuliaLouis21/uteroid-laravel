@extends('layouts.frontend')

@section('title', 'Hubungi Kami')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Hubungi Kami</h1>
            <p class="mt-2 text-gray-600">Kami siap membantu Anda. Kirim pesan atau hubungi kami langsung.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon <span class="text-gray-400">(opsional)</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('subject') border-red-500 @enderror"
                            required>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea name="message" id="message" rows="5"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('message') border-red-500 @enderror"
                            required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-brand hover:bg-brand-dark text-white font-semibold py-2 px-6 rounded-md transition">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>

                    <div class="space-y-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-brand-light rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-gray-900">Alamat</h3>
                                <p class="text-gray-600 mt-1">Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-brand-light rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-gray-900">Telepon</h3>
                                <p class="text-gray-600 mt-1">+62 21 1234 5678</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-brand-light rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600 mt-1">info@uterogroup.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-64 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm">Google Maps</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
