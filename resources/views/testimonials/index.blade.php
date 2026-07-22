@extends('layouts.frontend')

@section('title', 'Testimonial | Utero Advertising')
@section('meta_description', 'Testimonial dan ulasan dari klien Utero Advertising tentang layanan periklanan dan percetakan kami.')
@section('meta_keywords', 'testimonial utero, ulasan client, review advertising malang')

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
<div class="main-content">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-quote-right mr-2"></i>Testimonial</div>
        <div class="page-title-bar"></div>

        <div class="space-y-4">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-card">
                    <div class="testimonial-text">"{{ ucfirst($testimonial->content) }}"</div>
                    <div class="testimonial-info">
                        <i class="fas fa-user-circle mr-1"></i>{{ $testimonial->name }}
                        @if($testimonial->company)
                            <span class="text-gray-300 mx-1">|</span>{{ $testimonial->company }}
                        @endif
                        <br>
                        <i class="far fa-clock mr-1"></i>{{ $testimonial->created_at->format('M d, Y') }}
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-quote-right text-3xl mb-3 block"></i>
                    Belum ada testimonial.
                </div>
            @endforelse
        </div>

        <div class="flex justify-end mt-6">
            {{ $testimonials->links() }}
        </div>
    </div>

    {{-- Submit Testimonial --}}
    <div class="content-card mt-4">
        <div class="page-title text-lg"><i class="fas fa-pen mr-2"></i>Kirim Testimonial</div>
        <div class="page-title-bar"></div>

        <form method="POST" action="{{ route('testimonials.store') }}" class="form-horizontal">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="company">Perusahaan</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" placeholder="Nama perusahaan (opsional)">
            </div>
            <div class="form-group">
                <label for="content">Testimonial</label>
                <textarea name="content" id="content" rows="4" placeholder="Tulis testimonial Anda..." required>{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-testimonial">
                <button type="submit" class="form-submit">
                    <i class="fas fa-paper-plane"></i>Kirim Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@php $recaptchaSiteKey = config('recaptcha.site_key'); @endphp
@if($recaptchaSiteKey)
<script>
document.querySelector('form[action="{{ route('testimonials.store') }}"]').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ $recaptchaSiteKey }}', {action: 'testimonial'}).then(function(token) {
            document.getElementById('g-recaptcha-response-testimonial').value = token;
            form.submit();
        });
    });
});
</script>
@endif
@endpush
@endsection
