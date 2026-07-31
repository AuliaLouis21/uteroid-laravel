<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
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

    {{-- Preconnect --}}
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
    <link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
    <link rel="dns-prefetch" href="https://maps.googleapis.com">

    {{-- Preload header banner image to improve LCP --}}
    <link rel="preload" as="image" href="/images/header-banner.webp" type="image/webp" fetchpriority="high">

    {{-- Preload critical fonts - Poppins --}}
    <link rel="preload" as="font" type="font/woff2" href="/fonts/poppins/pxiEyp8kv8JHgFVrJJfecg.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/fonts/poppins/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/fonts/poppins/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2" crossorigin>

    {{-- Font Awesome fonts: let them load naturally on mobile, preload on desktop via JS --}}
    <script>
        (function(){
            var isMobile='ontouchstart' in window||navigator.maxTouchPoints>0;
            if(!isMobile){
                var fonts=['fa-solid-900','fa-brands-400','fa-regular-400'];
                fonts.forEach(function(f){
                    var l=document.createElement('link');
                    l.rel='preload';l.as='font';l.type='font/woff2';l.href='/fonts/'+f+'.woff2';l.crossOrigin='anonymous';
                    document.head.appendChild(l);
                });
            }
        })();
    </script>

    {{-- Inline FA @font-face so icons render immediately with above-the-fold content --}}
    <style>
        @font-face{font-family:"Font Awesome 6 Free";font-style:normal;font-weight:900;font-display:swap;src:url('/fonts/fa-solid-900.woff2') format('woff2')}
        @font-face{font-family:"Font Awesome 6 Free";font-style:normal;font-weight:400;font-display:swap;src:url('/fonts/fa-regular-400.woff2') format('woff2')}
        @font-face{font-family:"Font Awesome 6 Brands";font-style:normal;font-weight:400;font-display:swap;src:url('/fonts/fa-brands-400.woff2') format('woff2')}
        .fas,.fab,.far{font-style:normal;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
        .fas{font-family:"Font Awesome 6 Free";font-weight:900}
        .far{font-family:"Font Awesome 6 Free";font-weight:400}
        .fab{font-family:"Font Awesome 6 Brands";font-weight:400}
    </style>

    {{-- Critical inline CSS: ONLY above-the-fold rendering (header + navbar + body + layout primitives) --}}
    <style>
        body{margin:0;padding:0;background:#F3F4F6;font-family:'Poppins','Inter',sans-serif;font-size:14px;line-height:1.6;color:#374151;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;min-height:100vh;display:flex;flex-direction:column}
        *,*::before,*::after{box-sizing:border-box}
        html{min-height:100%;background-color:#1A1A2E}
        a{text-decoration:none;color:#ce181e}
        img{max-width:100%;height:auto}

        /* Header / Banner - LCP element */
        #header{width:100%;height:320px;background:#000;position:relative;overflow:hidden}
        #header .header-bg-img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
        #header::after{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(135deg,rgba(0,0,0,.75) 0%,rgba(206,24,30,.55) 100%)}
        #header .site-wrapper{position:relative;z-index:2;height:100%;display:flex;flex-direction:column;justify-content:flex-end;padding-bottom:32px}
        .header-overlay{position:relative;z-index:2}

        /* Navbar */
        .nav-bar{width:100%;background:#000;box-shadow:0 2px 12px rgba(0,0,0,.2);position:sticky;top:0;z-index:40}
        .nav-bar .nav-inner{display:flex;align-items:center;justify-content:space-between}
        .nav-bar .nav-brand{color:#fff;font-weight:700;font-size:18px;letter-spacing:.5px;padding:12px 8px;display:flex;align-items:center;gap:8px}
        .nav-bar .nav-brand span{color:#ce181e}
        .nav-bar ul{list-style:none;margin:0;padding:0;display:flex;align-items:center}
        .nav-bar ul li a{display:block;padding:12px 16px;font-size:14px;font-weight:500;color:rgba(255,255,255,.65);text-decoration:none;transition:all .25s ease}
        .nav-bar ul li a:hover{color:#fff}
        .nav-bar ul li a.active{color:#fff;font-weight:600;background:linear-gradient(180deg,rgba(206,24,30,.15),rgba(206,24,30,.05));border-bottom:2px solid #ce181e}
        .nav-toggle{display:none;cursor:pointer;color:rgba(255,255,255,.95);padding:10px 12px;font-size:18px;border:1px solid rgba(255,255,255,.12);border-radius:8px;background:rgba(255,255,255,.04)}

        /* Layout primitives */
        .site-wrapper{max-width:1320px;margin:0 auto;padding:0 16px;width:100%}
        .flex-1{flex:1}
        .text-white{color:#fff}
        .text-brand{color:#ce181e}
        .text-gray-300{color:#d1d5db}
        .text-sm{font-size:.875rem;line-height:1.25rem}
        .text-base{font-size:1rem;line-height:1.5rem}
        .text-3xl{font-size:1.875rem;line-height:2.25rem}
        .text-xs{font-size:.75rem;line-height:1rem}
        .font-bold{font-weight:700}
        .mb-2{margin-bottom:.5rem}
        .mr-1{margin-right:.25rem}
        .hidden{display:none}
        .md\:flex{display:none}
        .md\:text-4xl{font-size:1.875rem;line-height:2.25rem}
        .md\:text-base{font-size:1rem;line-height:1.5rem}

        /* Responsive: Tablet & below */
        @media(max-width:1024px){
            .nav-bar ul{display:none;flex-direction:column;width:100%;background:#111;border-top:1px solid rgba(255,255,255,.08);margin-top:8px;border-radius:10px;overflow:hidden}
            .nav-bar ul.open{display:flex}
            .nav-toggle{display:block}
            .nav-bar ul li{width:100%}
            .nav-bar ul li a{display:flex;align-items:center;gap:6px;border-bottom:1px solid rgba(255,255,255,.06);color:rgba(255,255,255,.88)}
            .nav-bar ul li:last-child a{border-bottom:0}
            .nav-bar ul li a.active{color:#fff;background:rgba(206,24,30,.08);border-left:3px solid #ce181e;padding-left:13px}
            #header{height:180px}
        }
        @media(max-width:767px){.site-wrapper{padding:0 12px}.nav-bar .nav-brand{font-size:14px}}
        @media(min-width:768px){.md\:flex{display:flex}.md\:text-4xl{font-size:2.25rem;line-height:2.5rem}.md\:text-base{font-size:1rem;line-height:1.5rem}}
    </style>

    @php
    $gaId = \Illuminate\Support\Facades\Cache::remember('setting_google_analytics_id', 3600, fn() => \App\Models\Setting::where('key', 'google_analytics_id')->value('value'));
    $waPhone = \Illuminate\Support\Facades\Cache::remember('setting_site_whatsapp', 3600, fn() => \App\Models\Setting::where('key', 'site_whatsapp')->value('value')) ?? '081999900900';
    @endphp

    {{-- In dev mode: use @vite for HMR. In production: defer CSS for non-render-blocking. --}}
    @if(app()->isLocal())
        @vite(['resources/css/app.css', 'resources/css/fa-subset.css', 'resources/css/fonts.css'])
    @else
        @php
            $manifestPath = public_path('build/manifest.json');
            $appManifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
            $cssApp = $appManifest['resources/css/app.css']['file'] ?? '';
            $cssFa = $appManifest['resources/css/fa-subset.css']['file'] ?? '';
            $cssFonts = $appManifest['resources/css/fonts.css']['file'] ?? '';
        @endphp
        @if($cssApp)
        <link rel="preload" href="/build/{{ $cssApp }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="/build/{{ $cssApp }}"></noscript>
        @endif
        @if($cssFonts)
        <link rel="preload" href="/build/{{ $cssFonts }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="/build/{{ $cssFonts }}"></noscript>
        @endif
        @if($cssFa)
        <link rel="preload" href="/build/{{ $cssFa }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="/build/{{ $cssFa }}"></noscript>
        @endif
    @endif

    @stack('styles')
</head>

<body>
    {{-- HEADER / BANNER --}}
    @if(!isset($hideHeader) || !$hideHeader)
    <div id="header">
        <picture>
            <source srcset="/images/header-banner.webp" type="image/webp">
            <img src="/images/header-banner.png" alt="Utero Advertising" width="1320" height="320" fetchpriority="high" decoding="async" class="header-bg-img"
                 sizes="(max-width: 767px) 100vw, (max-width: 1024px) 100vw, 1320px">
        </picture>
        <div class="site-wrapper">
            <div class="header-overlay" style="position:relative;z-index:2">
                <h1 class="text-white text-3xl md:text-4xl font-bold mb-2" style="text-shadow:0 2px 8px rgba(0,0,0,.5)">
                    UTERO <span class="text-brand">ADVERTISING</span>
                </h1>
                <p class="text-gray-300 text-sm md:text-base" style="text-shadow:0 1px 4px rgba(0,0,0,.5)">
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
                <div class="nav-brand">
                    <img src="{{ asset('images/LOGO UTERO-01.png') }}" alt="Utero Logo" style="height:32px;width:auto" loading="eager" width="96" height="32">
                    <span>UTERO ADVERTISING</span>
                </div>

                <button class="nav-toggle" @click="open = !open" :aria-expanded="open.toString()" aria-label="Toggle navigation menu">
                    <i :class="open ? 'fas fa-times' : 'fas fa-bars'" style="color:#fff"></i>
                </button>

                <ul :class="open ? 'open' : ''" class="md:flex">
                    <li>
                        <a href="{{ route('home') }}" title="Home" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="fas fa-home mr-1 text-xs"></i> HOME
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" title="Product" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-dollar-sign mr-1 text-xs"></i> PRICE
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" title="Gallery" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">
                            <i class="fas fa-images mr-1 text-xs"></i> GALLERY
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" title="News" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper mr-1 text-xs"></i> NEWS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('download.index') }}" title="Download" class="{{ request()->routeIs('download.*') ? 'active' : '' }}">
                            <i class="fas fa-download mr-1 text-xs"></i> DOWNLOAD
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('testimonials.index') }}" title="Testimonial" class="{{ request()->routeIs('testimonials.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope mr-1 text-xs"></i> TESTIMONIAL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" title="Kontak" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">
                            <i class="fas fa-phone mr-1 text-xs"></i> KONTAK
                        </a>
                    </li>
                    @foreach($staticPages as $sp)
                    <li>
                        <a href="{{ route('pages.show', $sp->slug) }}" title="{{ $sp->title }}" class="{{ request()->routeIs('pages.show', $sp->slug) ? 'active' : '' }}">
                            @if($sp->slug === 'tentang-kami')<i class="fas fa-info-circle mr-1 text-xs"></i> @endif{{ strtoupper($sp->title) }}
                        </a>
                    </li>
                    @endforeach
                    @auth
                    <li>
                        <span style="display:flex;align-items:center;gap:8px;padding:12px 16px;font-size:14px;font-weight:500;color:rgba(255,255,255,.65)">
                            <i class="fas fa-user-circle text-xs"></i>{{ Auth::user()->name }}
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" style="font-size:12px;padding:4px 8px;border-radius:4px;cursor:pointer;color:rgba(255,255,255,.65);background:none;border:none" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </span>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('login') }}" title="Login" class="{{ request()->routeIs('login') ? 'active' : '' }}">
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
    @include('layouts.partials._footer')

    {{-- WHATSAPP BUTTON --}}
    @php
    $waNumber = str_replace([' ', '-', '+'], '', $waPhone);
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" class="whatsapp-btn" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
        <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" width="30" height="30" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
    </a>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
        style="position:fixed;top:16px;right:16px;z-index:50;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:12px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1);font-size:14px;font-weight:500">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
        style="position:fixed;top:16px;right:16px;z-index:50;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:12px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1);font-size:14px;font-weight:500">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    {{-- Alpine.js - deferred --}}
    @if(app()->isLocal())
        @vite(['resources/js/app.js'])
    @else
        @if(!empty($appManifest['resources/js/app.js']['file']))
        <script defer src="/build/{{ $appManifest['resources/js/app.js']['file'] }}"></script>
        @endif
    @endif

    @stack('scripts')

    {{-- Google Analytics - lazy load after page idle (requestIdleCallback) --}}
    @if($gaId)
    <script>
    (function(){
        function loadGA(){
            var s=document.createElement('script');
            s.async=true;
            s.src='https://www.googletagmanager.com/gtag/js?id={{ $gaId }}';
            document.head.appendChild(s);
            window.dataLayer=window.dataLayer||[];
            function gtag(){dataLayer.push(arguments);}
            gtag('js',new Date());
            gtag('config','{{ $gaId }}');
        }
        if('requestIdleCallback' in window){requestIdleCallback(loadGA,{timeout:5000})}
        else{setTimeout(loadGA,200)}
    })();
    </script>
    @endif
</body>

</html>
