<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur. Solusi periklanan, cetak, dan desain kreatif untuk bisnis Anda.')">
    <meta name="keywords" content="@yield('meta_keywords', 'advertising malang, perusahaan advertising, utero advertising, printing, digital printing, creative agency, desain grafis, malang')">
    <meta name="robots" content="Index, Follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Utero Advertising | Idea And Concept Factory')">
    <meta property="og:description" content="@yield('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur.')">
    <meta property="og:image" content="@yield('og_image', asset('images/banner-web.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Utero Advertising">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Utero Advertising | Idea And Concept Factory')">
    <meta name="twitter:description" content="@yield('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/banner-web.jpg'))">

    <title>@yield('title', 'Utero Advertising | Idea And Concept Factory')</title>
    <link rel="icon" type="image/x-icon" href="/images/utero.ico">
    {{-- Preconnect for faster resource loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    {{-- Google Fonts - non-blocking load --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" as="style" crossorigin onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"></noscript>
    {{-- Preload header banner image to improve LCP --}}
    <link rel="preload" as="image" href="/images/header-banner.webp" type="image/webp">
    {{-- Font Awesome - non-blocking load for better mobile performance --}}
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" crossorigin onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    {{-- Critical inline CSS for above-the-fold rendering --}}
    <style>
        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;padding:0;font-family:'Poppins','Inter',sans-serif;font-size:14px;line-height:1.6;background:#F3F4F6;color:#374151}
        #header{width:100%;height:320px;background:#000;position:relative;overflow:hidden}
        #header img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
        #header::after{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(135deg,rgba(0,0,0,.75) 0%,rgba(206,24,30,.55) 100%)}
        .nav-bar{width:100%;background:#000;box-shadow:0 2px 12px rgba(0,0,0,.2);position:sticky;top:0;z-index:40}
        .site-wrapper{max-width:1320px;margin:0 auto;padding:0 16px;width:100%}
        .three-col{display:flex;flex-wrap:wrap;gap:24px;padding:24px 0}
        .sidebar-left{width:100%}
        .main-content{width:100%;flex:1;min-width:0}
        .sidebar-right{width:100%}
        .sidebar-card{background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.1);overflow:hidden}
        .sidebar-card .card-header{padding:14px 20px;font-weight:600;font-size:14px;text-transform:uppercase;letter-spacing:1.5px;background:#000;color:#fff}
        .content-card{background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:24px;margin-bottom:16px}
        .page-title{font-size:24px;font-weight:700;margin-bottom:4px;color:#000}
        .page-title-bar{width:48px;height:4px;border-radius:9999px;margin-bottom:24px;background:linear-gradient(90deg,#ce181e,#a01418)}
        h1,h2,h3{color:#000}
        img{max-width:100%;height:auto}
        @media(max-width:1024px){.three-col{flex-direction:column;gap:24px}}
        @media(min-width:1025px){.sidebar-left{width:240px;flex-shrink:0}.sidebar-right{width:280px;flex-shrink:0}}
        @media(max-width:767px){#header{height:180px}}
    </style>
    @vite(['resources/css/app.css'])
    <script>
        /* Convert render-blocking CSS to non-blocking */
        document.querySelectorAll('link[rel="stylesheet"][href*="/build/assets/"]').forEach(function(link) {
            link.setAttribute('media', 'print');
            link.onload = function() { this.media = 'all'; };
        });
    </script>

    @php
    $gaId = \Illuminate\Support\Facades\Cache::remember('setting_google_analytics_id', 3600, fn() => \App\Models\Setting::where('key', 'google_analytics_id')->value('value'));
    $waPhone = \Illuminate\Support\Facades\Cache::remember('setting_site_whatsapp', 3600, fn() => \App\Models\Setting::where('key', 'site_whatsapp')->value('value')) ?? '081999900900';
    $recaptchaSiteKey = config('recaptcha.site_key') ?: (\Illuminate\Support\Facades\Cache::remember('setting_recaptcha_site_key', 3600, fn() => \App\Models\Setting::where('key', 'recaptcha_site_key')->value('value')) ?? '');
    @endphp

    @if($recaptchaSiteKey)
    <script defer src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
    @endif

    @stack('styles')
</head>

<body>
    {{-- HEADER / BANNER --}}
    @if(!isset($hideHeader) || !$hideHeader)
    <div id="header">
        <picture>
            <source srcset="/images/header-banner.webp" type="image/webp">
            <img src="/images/header-banner.png" alt="Utero Advertising" width="1320" height="320" fetchpriority="high" decoding="async" class="header-bg-img">
        </picture>
        <div class="site-wrapper">
            <div class="header-overlay">
                <h1 class="text-white text-3xl md:text-4xl font-bold mb-2" style="text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                    UTERO <span class="text-brand">ADVERTISING</span>
                </h1>
                <p class="text-gray-300 text-sm md:text-base" style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                    Idea And Concept Factory — Advertising, Digital Printing & Creative Agency
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- NAVBAR --}}
    <div class="nav-bar">
        <div class="site-wrapper">
            <div class="nav-inner" x-data="{ open: false }">
                <div class="nav-brand hidden md:flex items-center gap-2">
                    <img src="{{ asset('images/LOGO UTERO-01.png') }}" alt="Utero Logo" class="h-8 w-auto" loading="eager">
                    <span>UTERO ADVERTISING</span>
                </div>

                <button class="nav-toggle md:hidden" @click="open = !open" :aria-expanded="open.toString()" aria-label="Toggle navigation menu">
                    <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-white"></i>
                </button>

                <ul :class="open ? 'open' : ''" class="md:flex">
                    <li>
                        <a href="{{ route('home') }}" title="Home" {{ request()->routeIs('home') ? 'class="active"' : '' }}>
                            <i class="fas fa-home mr-1 text-xs"></i> HOME
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" title="Product" {{ request()->routeIs('products.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-dollar-sign mr-1 text-xs"></i> PRICE
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" title="Gallery" {{ request()->routeIs('gallery.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-images mr-1 text-xs"></i> GALLERY
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" title="News" {{ request()->routeIs('posts.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-newspaper mr-1 text-xs"></i> NEWS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('download.index') }}" title="Download" {{ request()->routeIs('download.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-download mr-1 text-xs"></i> DOWNLOAD
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('testimonials.index') }}" title="Testimonial" {{ request()->routeIs('testimonials.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-quote-right mr-1 text-xs"></i> TESTIMONIAL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" title="Kontak" {{ request()->routeIs('contact.*') ? 'class="active"' : '' }}>
                            <i class="fas fa-phone mr-1 text-xs"></i> KONTAK
                        </a>
                    </li>
                    @foreach($staticPages as $sp)
                    <li>
                        <a href="{{ route('pages.show', $sp->slug) }}" title="{{ $sp->title }}" {{ request()->routeIs('pages.show', $sp->slug) ? 'class="active"' : '' }}>
                            @if($sp->slug === 'tentang-kami')<i class="fas fa-info-circle mr-1 text-xs"></i> @endif{{ strtoupper($sp->title) }}
                        </a>
                    </li>
                    @endforeach
                    @auth
                    <li>
                        <span class="flex items-center gap-2 px-4 py-3 text-sm font-medium" style="color: rgba(255, 255, 255, 0.65);">
                            <i class="fas fa-user-circle text-xs"></i>{{ Auth::user()->name }}
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs px-2 py-1 rounded transition-colors cursor-pointer hover:text-white" style="color: rgba(255, 255, 255, 0.65); background: none; border: none;" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </span>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('login') }}" title="Login" {{ request()->routeIs('login') ? 'class=active' : '' }}>
                            <i class="fas fa-sign-in-alt mr-1 text-xs"></i> LOGIN
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>

    {{-- HERO SECTION (full-width) --}}
    @hasSection('hero')
        @yield('hero')
    @endif

    {{-- MAIN CONTENT --}}
    <div class="flex-1">
        <div class="site-wrapper">
            @unless(isset($noSidebar) && $noSidebar)
            <div class="three-col">
                @yield('sidebar-left')
                @yield('content')
                @yield('sidebar-right')
            </div>
            @else
            @yield('content')
            @endunless
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer-area">
        <div class="site-wrapper py-16">
            <div class="footer-grid">
                {{-- Kolom 1: Who We Are --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-building mr-2"></i>Who We Are?</div>
                    <div class="footer-text mb-4">
                        Suatu perusahaan yang bergerak dalam bidang jasa dan produk periklanan,
                        idea dan concept yang konsisten dalam membantu para kliennya untuk
                        mewujudkan nilai-nilai penjualan yang maksimal.
                        <a href="{{ route('pages.show', 'tentang-kami') }}" title="About Us" class="block mt-2">read more <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="flex gap-3 items-center">
                        <a href="https://www.facebook.com/uteroadvertisingindonesia" target="_blank" rel="noopener noreferrer" title="Facebook" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/uteroindonesia" target="_blank" rel="noopener noreferrer" title="Twitter" class="social-icon twitter"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/uteroindonesia" target="_blank" rel="noopener noreferrer" title="Instagram" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCkdJC5Tw0bk0xK9sUR80xnA" target="_blank" rel="noopener noreferrer" title="YouTube" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.youtube.com/channel/UC--Vge6YlX1y65HqjqYP8uQ" target="_blank" rel="noopener noreferrer" title="YouTube 2" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                {{-- Kolom 2: Lokasi Kami --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kami</div>
                    <div class="rounded-lg overflow-hidden mb-4 border border-white/10">
                        <iframe loading="lazy" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2886993069!2d112.6317828409092!3d-7.9786290600267975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629c5e8a20281%3A0x3ff201ddaa440c96!2sPT%20UTERO%20KREATIF%20INDONESIA!5e0!3m2!1sen!2sid!4v1696298771980!5m2!1sen!2sid" width="100%" height="180" frameborder="0" style="border:0; border-radius:8px;" allowfullscreen title="Lokasi Utero Advertising"></iframe>
                    </div>
                </div>

                {{-- Kolom 3: Testimonial --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-quote-left mr-2"></i>Testimonial <a href="{{ route('testimonials.index') }}" class="text-xs">Read More <i class="fas fa-arrow-right"></i></a></div>
                    @php
                    $randomTestimonial = \Illuminate\Support\Facades\Cache::remember('random_approved_testimonial', 3600, fn() => \App\Models\Testimonial::where('status', 'approved')->inRandomOrder()->first());
                    @endphp
                    @if($randomTestimonial)
                    <div class="testimonial-card" style="border-left-color: #ce181e;">
                        <div class="testimonial-text">{{ ucfirst($randomTestimonial->content) }}</div>
                        <div class="testimonial-stars" aria-label="Rating {{ $randomTestimonial->rating }} dari 5">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="testimonial-star {{ $i <= $randomTestimonial->rating ? 'is-filled' : 'is-empty' }}" aria-hidden="true">&#9733;</span>
                            @endfor
                        </div>
                        <div class="testimonial-info">From: {{ $randomTestimonial->name }} &rarr; {{ $randomTestimonial->created_at->format('M d, Y') }}</div>
                    </div>
                    @else
                    <p class="text-gray-400 text-sm">Belum ada testimonial.</p>
                    @endif
                </div>

                {{-- Kolom 4: Contact Us --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-phone mr-2"></i>Contact Us</div>
                    <div class="footer-text">
                        <p class="font-semibold text-white mb-1">PT. UTERO KREATIF INDONESIA</p>
                        <p class="text-xs text-gray-400 mb-3">RUMAH MERAH OXYZ</p>
                        <div class="space-y-2 text-sm">
                            <p><i class="fas fa-map-pin mr-2 text-brand"></i>Jl. Bantaran 1 No. 25, Tulusrejo, Lowokwaru, Malang 65141</p>
                            <p><i class="fas fa-phone mr-2 text-brand"></i>0341 408408</p>
                            <p><i class="fab fa-whatsapp mr-2 text-brand"></i>+62 819-9990-0900 (Pak Dadik)<br>
                                <!-- <span class="ml-5">+62 817-3886-1688 (utero)</span> -->
                            </p>
                            <p><i class="fas fa-envelope mr-2 text-brand"></i>marketingutero@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="site-wrapper flex justify-between items-center">
                <span>&copy; 2009-{{ date('Y') }} uterogroup.com, All Right Reserved</span>
                <span class="text-gray-400 text-xs">Idea And Concept Factory</span>
            </div>
        </div>
    </div>

    {{-- WHATSAPP BUTTON --}}
    @php
    $waNumber = str_replace([' ', '-', '+'], '', $waPhone);
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" class="whatsapp-btn" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
    </a>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
        class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-card shadow-lg text-sm font-medium">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
        class="fixed top-4 right-4 z-50 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-card shadow-lg text-sm font-medium">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    {{-- Alpine.js loaded deferred for non-blocking --}}
    @vite(['resources/js/app.js'])

    @stack('scripts')

    {{-- Google Analytics - moved to end of body for non-render-blocking --}}
    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
    @endif
</body>

</html>