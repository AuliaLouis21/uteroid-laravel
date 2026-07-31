@extends('layouts.frontend')

@section('title', 'Kontak | Utero Advertising')
@section('meta_description', 'Hubungi Utero Advertising untuk konsultasi periklanan, digital printing, dan desain kreatif. Alamat, telepon, dan WhatsApp kami.')
@section('meta_keywords', 'kontak utero, hubungi utero, alamat utero advertising, telepon utero')

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

    <div class="sidebar-card mt-4">
        <div class="card-header">
            <i class="fas fa-info-circle"></i>Info Kontak
        </div>
        <div class="p-5 space-y-3 text-sm">
            <p class="flex items-start gap-2"><i class="fas fa-map-pin text-brand mt-1"></i>Jl. Bantaran 1 No. 25, Malang 65141</p>
            <p class="flex items-start gap-2"><i class="fas fa-phone text-brand mt-1"></i>0341 408408</p>
            <p class="flex items-start gap-2"><svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ce181e" class="mt-1 flex-shrink-0" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>081 999 900 900</p>
            <p class="flex items-start gap-2"><i class="fas fa-envelope text-brand mt-1"></i>marketingutero@gmail.com</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-phone mr-2"></i>Hubungi Kami</div>
        <div class="page-title-bar"></div>

        <form method="POST" action="{{ route('contact.send') }}" class="form-horizontal">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Masukkan email Anda" required>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Nomor telepon (opsional)">
            </div>
            <div class="form-group">
                <label for="subject">Subjek</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Subjek pesan" required>
            </div>
            <div class="form-group">
                <label for="message">Pesan</label>
                <textarea name="message" id="message" rows="5" placeholder="Tulis pesan Anda..." required>{{ old('message') }}</textarea>
                @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-contact">
                <button type="submit" class="form-submit">
                    <i class="fas fa-paper-plane"></i>Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@php $recaptchaSiteKey = config('recaptcha.site_key'); @endphp
@if($recaptchaSiteKey)
<script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}" async></script>
<script>
document.querySelector('form[action="{{ route('contact.send') }}"]').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ $recaptchaSiteKey }}', {action: 'contact'}).then(function(token) {
            document.getElementById('g-recaptcha-response-contact').value = token;
            form.submit();
        });
    });
});
</script>
@endif
@endpush
@endsection
