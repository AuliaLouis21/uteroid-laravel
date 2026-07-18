@extends('layouts.frontend')

@section('title', 'Testimonial | Utero Advertising')

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
<div class="main-content">
    <div class="detail-section">
        <h1 style="border-bottom:1px solid #999; padding-bottom:4px; margin-bottom:8px;">
            Testimonial
        </h1>
    </div>

    @forelse($testimonials as $testimonial)
        <div style="display:block; clear:both; padding:6px 2px; border-bottom:1px solid #EFEFEF; border-top:1px solid #FFF;">
            <div class="testimonial-text" style="text-align:justify;">{{ ucfirst($testimonial->content) }}</div>
            <div class="testimonial-info">From : {{ $testimonial->name }} &rarr;<br> {{ $testimonial->created_at->format('F jS, Y') }}</div>
        </div>
    @empty
        <p class="text-gray-500 text-center py-4">Belum ada testimonial.</p>
    @endforelse

    <div class="text-right mt-4">
        {{ $testimonials->links() }}
    </div>

    <div class="detail-section mt-8" style="border-top:2px solid #333; padding-top:8px;">
        <h2 style="font:bold 14px/100% 'Helvetica Neue', Helvetica, Arial, sans-serif; margin-bottom:8px;">Kirim Testimonial</h2>
        <form method="POST" action="{{ route('testimonials.store') }}" class="form-style">
            @csrf
            <span>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </span>
            <span>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </span>
            <span>
                <label for="company">Perusahaan</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}">
            </span>
            <span>
                <label for="content">Testimonial</label>
                <textarea name="content" id="content" required>{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </span>
            <span>
                <label>&nbsp;</label>
                <input type="submit" value="Kirim">
            </span>
        </form>
    </div>
</div>
@endsection
