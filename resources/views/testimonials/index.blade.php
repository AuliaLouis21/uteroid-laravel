@extends('layouts.frontend')

@section('title', 'Testimoni Pelanggan')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Testimoni Pelanggan</h1>
            <p class="mt-2 text-gray-600">Apa kata mereka tentang produk dan layanan kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
            @forelse($testimonials as $testimonial)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $testimonial->name }}</h3>
                            @if($testimonial->company)
                                <p class="text-sm text-gray-500">{{ $testimonial->company }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>

                    <p class="text-gray-600 leading-relaxed">{{ $testimonial->content }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Belum ada testimoni dari pelanggan.</p>
                </div>
            @endforelse
        </div>

        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Testimoni Anda</h2>

            <form action="{{ route('testimonials.store') }}" method="POST">
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
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Perusahaan <span class="text-gray-400">(opsional)</span></label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('company') border-red-500 @enderror">
                    @error('company')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4" x-data="{ rating: {{ old('rating', 5) }} }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}"
                                class="focus:outline-none"
                                :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" :value="rating">
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Testimoni</label>
                    <textarea name="content" id="content" rows="4"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand @error('content') border-red-500 @enderror"
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white font-semibold py-2 px-6 rounded-md transition">
                        Kirim Testimoni
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection
