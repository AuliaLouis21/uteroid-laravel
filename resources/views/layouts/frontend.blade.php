<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Utero Group'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-black shadow sticky top-0 z-50" x-data="{ open: false, menuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">U</span>
                        </div>
                        <span class="text-xl font-bold text-white">Utero Group</span>
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Beranda</a>
                    <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Produk</a>
                    <a href="{{ route('posts.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('posts.*') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Berita</a>
                    <a href="{{ route('gallery.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('gallery.*') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Galeri</a>
                    <a href="{{ route('testimonials.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('testimonials.*') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Testimoni</a>
                    <a href="{{ route('contact.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('contact.*') ? 'text-brand bg-brand-light' : 'text-gray-300 hover:text-white' }}">Kontak</a>
                    <a href="{{ route('order.create') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-brand hover:bg-brand-dark ml-2">Pesan Sekarang</a>

                    @auth
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="ml-2 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white">Login</a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <div class="md:hidden flex items-center">
                    <button @click="menuOpen = !menuOpen" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="menuOpen" x-transition class="md:hidden border-t border-gray-800">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-brand bg-brand-light' : 'text-gray-300' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products.*') ? 'text-brand bg-brand-light' : 'text-gray-300' }}">Produk</a>
                <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('posts.*') ? 'text-brand bg-brand-light' : 'text-gray-300' }}">Berita</a>
                <a href="{{ route('gallery.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('gallery.*') ? 'text-brand bg-brand-light' : 'text-gray-300' }}">Galeri</a>
                <a href="{{ route('testimonials.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300">Testimoni</a>
                <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300">Kontak</a>
                <a href="{{ route('order.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-brand text-center">Pesan Sekarang</a>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                {{ session('success') }}
                <button @click="show = false" class="float-right">&times;</button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-black text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">U</span>
                        </div>
                        <span class="text-xl font-bold text-white">Utero Group</span>
                    </div>
                    <p class="text-gray-400 text-sm">Penyedia solusi packaging dan printing berkualitas tinggi untuk kebutuhan bisnis Anda.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-3 text-white">Navigasi</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-white">Produk</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-white">Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-3 text-white">Layanan</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('order.create') }}" class="hover:text-white">Pesan Produk</a></li>
                        <li><a href="{{ route('testimonials.index') }}" class="hover:text-white">Testimoni</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-white">Hubungi Kami</a></li>
                        <li><a href="{{ route('download.index') }}" class="hover:text-white">Download</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-3 text-white">Kontak</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-start space-x-2">
                            <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Malang, Indonesia</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@uterogroup.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Utero Group. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
