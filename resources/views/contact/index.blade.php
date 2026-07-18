@extends('layouts.frontend')

@section('title', 'Kontak | Utero Advertising')

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
            Hubungi Kami
        </h1>
    </div>

    <div class="detail-section">
        <form method="POST" action="{{ route('contact.send') }}" class="form-style">
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
                <label for="phone">Telepon</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}">
            </span>
            <span>
                <label for="subject">Subjek</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required>
            </span>
            <span>
                <label for="message">Pesan</label>
                <textarea name="message" id="message" required>{{ old('message') }}</textarea>
                @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </span>
            <span>
                <label>&nbsp;</label>
                <input type="submit" value="Kirim">
            </span>
        </form>
    </div>
</div>
@endsection
