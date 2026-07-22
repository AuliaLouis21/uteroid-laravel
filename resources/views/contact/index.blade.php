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
            <p class="flex items-start gap-2"><i class="fab fa-whatsapp text-brand mt-1"></i>081 999 900 900</p>
            <p class="flex items-start gap-2"><i class="fas fa-envelope text-brand mt-1"></i>marketingutero@gmail.com</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-envelope mr-2"></i>Hubungi Kami</div>
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
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
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
