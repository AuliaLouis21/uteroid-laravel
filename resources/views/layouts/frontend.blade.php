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
    <meta property="og:image" content="@yield('og_image', asset('images/header-banner.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Utero Advertising">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Utero Advertising | Idea And Concept Factory')">
    <meta name="twitter:description" content="@yield('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/header-banner.png'))">

    <title>@yield('title', 'Utero Advertising | Idea And Concept Factory')</title>
    <link rel="icon" type="image/x-icon" href="/images/utero.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $gaId = \Illuminate\Support\Facades\Cache::remember('setting_google_analytics_id', 3600, fn() => \App\Models\Setting::where('key', 'google_analytics_id')->value('value'));
        $waPhone = \Illuminate\Support\Facades\Cache::remember('setting_site_whatsapp', 3600, fn() => \App\Models\Setting::where('key', 'site_whatsapp')->value('value')) ?? '081999900900';
        $recaptchaSiteKey = config('recaptcha.site_key') ?: (\Illuminate\Support\Facades\Cache::remember('setting_recaptcha_site_key', 3600, fn() => \App\Models\Setting::where('key', 'recaptcha_site_key')->value('value')) ?? '');
    @endphp

    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif

    @if($recaptchaSiteKey)
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
    @endif

    @stack('styles')
</head>
<body>
    {{-- HEADER / BANNER --}}
    <div id="header">
        <div class="site-wrapper">
            <div class="header-overlay">
                <h1 class="text-white text-3xl md:text-4xl font-bold mb-2" style="text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                    UTERO <span class="text-gold">ADVERTISING</span>
                </h1>
                <p class="text-gray-300 text-sm md:text-base" style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                    Idea And Concept Factory — Advertising, Digital Printing & Creative Agency
                </p>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <div class="nav-bar">
        <div class="site-wrapper">
            <div class="nav-inner" x-data="{ open: false }">
                <div class="nav-brand hidden md:block">
                    <span>UTERO</span> ADVERTISING
                </div>
                <button class="nav-toggle md:hidden" @click="open = !open">
                    <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-white"></i>
                </button>
                <ul :class="open ? 'open' : ''" class="md:flex">
                    <li>
                        <a href="{{ route('home') }}" title="Home" {{ request()->routeIs('home') ? 'class=active' : '' }}>
                            <i class="fas fa-home mr-1 text-xs"></i> HOME
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" title="Product" {{ request()->routeIs('products.*') ? 'class=active' : '' }}>
                            <i class="fas fa-box mr-1 text-xs"></i> PRICE
                        </a>
                    </li>
                    @foreach($staticPages as $sp)
                        <li>
                            <a href="{{ route('pages.show', $sp->slug) }}" title="{{ $sp->title }}" {{ request()->routeIs('pages.show') && request('slug') == $sp->slug ? 'class=active' : '' }}>
                                {{ strtoupper($sp->title) }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('download.index') }}" title="Download" {{ request()->routeIs('download.*') ? 'class=active' : '' }}>
                            <i class="fas fa-download mr-1 text-xs"></i> DOWNLOAD
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" title="Gallery" {{ request()->routeIs('gallery.*') ? 'class=active' : '' }}>
                            <i class="fas fa-images mr-1 text-xs"></i> GALLERY
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" title="News" {{ request()->routeIs('posts.*') ? 'class=active' : '' }}>
                            <i class="fas fa-newspaper mr-1 text-xs"></i> NEWS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('testimonials.index') }}" title="Testimonial" {{ request()->routeIs('testimonials.*') ? 'class=active' : '' }}>
                            <i class="fas fa-quote-right mr-1 text-xs"></i> TESTIMONIAL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" title="Kontak" {{ request()->routeIs('contact.*') ? 'class=active' : '' }}>
                            <i class="fas fa-envelope mr-1 text-xs"></i> KONTAK
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- NEWS TICKER --}}
    @php
        $tickerPosts = \Illuminate\Support\Facades\Cache::remember('news_ticker_posts', 600, fn() => \App\Models\News::latest()->take(10)->get());
        $tickerItems = $tickerPosts->map(function($p) {
            $date = $p->published_at ? $p->published_at->format('M d, Y') : $p->created_at->format('M d, Y');
            $url = route('posts.show', $p->slug);
            $title = e(ucwords($p->title));
            return "$date : <a href=\"$url\" title=\"$title\">$title</a>";
        })->values();
    @endphp
    <div class="news-ticker"
         x-data="{ current: 0, items: @json($tickerItems) }"
         x-init="setInterval(() => current = (current + 1) % items.length, 4000)">
        <ul>
            <template x-for="(item, i) in items" :key="i">
                <li x-show="current === i" x-transition x-html="item"></li>
            </template>
        </ul>
    </div>

    {{-- MAIN CONTENT --}}
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

    {{-- FOOTER --}}
    <div class="footer-area">
        <div class="site-wrapper py-8">
            <div class="footer-grid">
                {{-- Who We Are --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-building mr-2"></i>Who We Are?</div>
                    <div class="footer-text mb-4">
                        Suatu perusahaan yang bergerak dalam bidang jasa dan produk periklanan,
                        idea dan concept yang konsisten dalam membantu para kliennya untuk
                        mewujudkan nilai-nilai penjualan yang maksimal.
                        <a href="{{ route('pages.show', 'tentang-kami') }}" title="About Us" class="block mt-2">read more &rarr;</a>
                    </div>
                    <div class="flex gap-2">
                        <a href="http://www.facebook.com/uteroadvertisingindonesia" target="_blank" title="Facebook" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/uteroindonesia" target="_blank" title="Twitter" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                        <a href="http://instagram.com/uteroindonesia" target="_blank" title="Instagram" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCkdJC5Tw0bk0xK9sUR80xnA" target="_blank" title="YouTube" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.youtube.com/channel/UC--Vge6YlX1y65HqjqYP8uQ" target="_blank" title="YouTube 2" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                {{-- Map & Testimonial --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kami</div>
                    <div class="rounded-lg overflow-hidden mb-4 border border-white/10">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2886993069!2d112.6317828409092!3d-7.9786290600267975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629c5e8a20281%3A0x3ff201ddaa440c96!2sPT%20UTERO%20KREATIF%20INDONESIA!5e0!3m2!1sen!2sid!4v1696298771980!5m2!1sen!2sid" width="100%" height="180" frameborder="0" style="border:0; border-radius:8px;" allowfullscreen></iframe>
                    </div>
                    <div class="footer-label"><i class="fas fa-quote-left mr-2"></i>Testimonial <a href="{{ route('testimonials.index') }}" class="text-xs">Read More &rarr;</a></div>
                    @php
                        $randomTestimonial = \Illuminate\Support\Facades\Cache::remember('random_approved_testimonial', 3600, fn() => \App\Models\Testimonial::where('status', 'approved')->inRandomOrder()->first());
                    @endphp
                    @if($randomTestimonial)
                        <div class="testimonial-card" style="border-left-color: #D4AF37;">
                            <div class="testimonial-text">{{ ucfirst($randomTestimonial->content) }}</div>
                            <div class="testimonial-info">From: {{ $randomTestimonial->name }} &rarr; {{ $randomTestimonial->created_at->format('M d, Y') }}</div>
                        </div>
                    @endif
                </div>

                {{-- Contact Us --}}
                <div class="footer-col">
                    <div class="footer-label"><i class="fas fa-phone mr-2"></i>Contact Us</div>
                    <div class="footer-text">
                        <p class="font-semibold text-white mb-1">PT. UTERO KREATIF INDONESIA</p>
                        <p class="text-xs text-gray-400 mb-3">RUMAH MERAH OXYZ</p>
                        <div class="space-y-2 text-sm">
                            <p><i class="fas fa-map-pin mr-2 text-gold"></i>Jl. Bantaran 1 No. 25, Tulusrejo, Lowokwaru, Malang 65141</p>
                            <p><i class="fas fa-phone mr-2 text-gold"></i>0341 408408</p>
                            <p><i class="fab fa-whatsapp mr-2 text-gold"></i>081 999 900 900 (wahyu)<br>
                            <span class="ml-5">081 7388 616 (utero)</span></p>
                            <p><i class="fas fa-envelope mr-2 text-gold"></i>marketingutero@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="site-wrapper flex justify-between items-center">
                <span>&copy; 2009-{{ date('Y') }} uterogroup.com, All Right Reserved</span>
                <span class="text-gold text-xs">Idea And Concept Factory</span>
            </div>
        </div>
    </div>

    {{-- WHATSAPP BUTTON --}}
    @php
        $waNumber = str_replace([' ', '-', '+'], '', $waPhone);
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" class="whatsapp-btn" target="_blank">
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

    @stack('scripts')
</body>
</html>
