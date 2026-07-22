<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Utero Advertising — Advertising, Digital Printing & Creative Agency di Malang, Jawa Timur. Solusi periklanan, cetak, dan desain kreatif untuk bisnis Anda.')">
    <meta name="keywords" content="@yield('meta_keywords', 'advertising malang, perusahaan advertising, utero advertising, printing, digital printing, creative agency, desain grafis, malang')">
    <meta name="robots" content="Index, Follow">

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
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
<body class="m-0 p-0">
    <div id="header">
        <div class="site-wrapper" style="height:100%;">&nbsp;</div>
    </div>

    <div class="nav-bar">
        <div id="menubar" class="site-wrapper">
            <div x-data="{ open: false }">
                <span class="nav-toggle" @click="open = !open"><i class="fa fa-bars"></i> Menu</span>
                <ul :class="open ? 'open' : ''">
                    <li><a href="{{ route('home') }}" title="Home" style="border-left:none;" {{ request()->routeIs('home') ? 'class=active' : '' }}>HOME</a></li>
                    <li><a href="{{ route('products.index') }}" title="Product" {{ request()->routeIs('products.*') ? 'class=active' : '' }}>PRICE</a></li>
                    @foreach($staticPages as $sp)
                        <li><a href="{{ route('pages.show', $sp->slug) }}" title="{{ $sp->title }}" {{ request()->routeIs('pages.show') && request('slug') == $sp->slug ? 'class=active' : '' }}>{{ strtoupper($sp->title) }}</a></li>
                    @endforeach
                    <li><a href="{{ route('download.index') }}" title="Download" {{ request()->routeIs('download.*') ? 'class=active' : '' }}>DOWNLOAD</a></li>
                    <li><a href="{{ route('gallery.index') }}" title="Gallery" style="border-right:none;" {{ request()->routeIs('gallery.*') ? 'class=active' : '' }}>GALLERY</a></li>
                    <li><a href="{{ route('posts.index') }}" title="News" {{ request()->routeIs('posts.*') ? 'class=active' : '' }}>NEWS</a></li>
                    <li><a href="{{ route('testimonials.index') }}" title="Testimonial" {{ request()->routeIs('testimonials.*') ? 'class=active' : '' }}>TESTIMONIAL</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="body" class="overflow-hidden">
        @php
            $tickerPosts = \Illuminate\Support\Facades\Cache::remember('news_ticker_posts', 600, fn() => \App\Models\News::latest()->take(10)->get());
            $tickerItems = $tickerPosts->map(function($p) {
                $date = $p->published_at ? $p->published_at->format('F jS, Y') : $p->created_at->format('F jS, Y');
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

        @unless(isset($noSidebar) && $noSidebar)
            <div class="site-wrapper">
                @yield('sidebar-left')

                @yield('content')

                @yield('sidebar-right')
            </div>
        @else
            @yield('content')
        @endunless
    </div>

    <div class="footer-area">
        <div class="site-wrapper" style="border-bottom:1px solid #111;">
            <div class="footer-col1">
                <div class="footer-label">Who We Are?</div>
                <div class="footer-text">
                    Suatu perusahaan yang bergerak dalam bidang jasa dan produk periklanan,
                    idea dan concept yang konsisten dalam membantu para kliennya untuk
                    mewujudkan nilai-nilai penjualan yang maksimal melalui concept-concept
                    ide baik dalam grafis maupun photografi yang diolah dengan
                    perangkat computer dan peralatan canggih
                    <a href="{{ route('pages.show', 'tentang-kami') }}" title="About Us">read more &rarr;</a>
                </div>
                <a href="http://www.facebook.com/uteroadvertisingindonesia" target="_blank" title="Find us on Facebook">
                    <img src="/images/new-fb.png" height="45" alt="Find us on Facebook" style="border:none;padding-bottom:15px; max-width:100%; height:auto;">
                </a>
                <a href="https://x.com/uteroindonesia" target="_blank" title="Follow us on Twitter">
                    <img src="/images/new-twitter.png" height="45" alt="Follow us on Twitter" style="border:none;padding-bottom:15px; max-width:100%; height:auto;">
                </a>
                <a href="http://instagram.com/uteroindonesia" target="_blank" title="Find us on Instagram">
                    <img src="/images/new-instagram.png" height="45" alt="Find us on Instagram" style="border:none;padding-bottom:15px; max-width:100%; height:auto;">
                </a>
                <a href="https://www.youtube.com/channel/UCkdJC5Tw0bk0xK9sUR80xnA" target="_blank" title="Find us on Youtube">
                    <img src="/images/new-youtube.png" height="45" alt="Find us on Youtube" style="border:none;padding-bottom:15px; max-width:100%; height:auto;">
                </a>
                <a href="https://www.youtube.com/channel/UC--Vge6YlX1y65HqjqYP8uQ" target="_blank" title="Find us on Youtube">
                    <img src="/images/new-youtube2.png" height="45" alt="Find us on Youtube" style="border:none;padding-bottom:15px; max-width:100%; height:auto;">
                </a>
            </div>
            <div class="footer-col3">
                <div class="footer-text">
                    <div class="text-center">
                        <div class="footer-label">Contact Us</div>
                        PT. UTERO KREATIF INDONESIA
                    </div><br>
                    <div class="footer-label"><div class="text-center">RUMAH MERAH OXYZ</div></div>
                    <div class="text-center">
                        Jalan Bantaran 1 No. 25<br>
                        Tulusrejo, Kec. Lowokwaru<br>
                        Malang - Jawa Timur<br>
                        Indonesia<br>65141<br><br>
                        <b>No. Telpon</b><br>0341 408408<br><br>
                        <b>WhatsApp</b><br>
                        081 999 900 900 (wahyu)<br>
                        081 7388 616 (utero)<br><br>
                        <b>Email</b><br>marketingutero@gmail.com<br><br>
                    </div>
                </div>
            </div>
            <div class="footer-col2">
                <div class="footer-text">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2886993069!2d112.6317828409092!3d-7.9786290600267975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629c5e8a20281%3A0x3ff201ddaa440c96!2sPT%20UTERO%20KREATIF%20INDONESIA!5e0!3m2!1sen!2sid!4v1696298771980!5m2!1sen!2sid" width="100%" height="270" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <br>
                <div class="footer-label">Testimonial &raquo;
                    <a href="{{ route('testimonials.index') }}">Read More &rarr;</a>
                </div>
                @php
                    $randomTestimonial = \Illuminate\Support\Facades\Cache::remember('random_approved_testimonial', 3600, fn() => \App\Models\Testimonial::where('status', 'approved')->inRandomOrder()->first());
                @endphp
                @if($randomTestimonial)
                <div class="footer-text">
                    <div class="testimonial-text" style="text-align:justify;">{{ ucfirst($randomTestimonial->content) }}</div>
                    <div class="testimonial-info">From : {{ $randomTestimonial->name }} &rarr;<br> {{ $randomTestimonial->created_at->format('F jS, Y') }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="site-wrapper">
            <div class="footer-copyright flex justify-between items-center">
                <span>&copy; 2009-{{ date('Y') }} uterogroup.com, All Right Reserved</span>
            </div>
        </div>
    </div>

    @php
        $waNumber = str_replace([' ', '-', '+'], '', $waPhone);
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" class="whatsapp-btn" target="_blank">
        <i class="fa fa-whatsapp icon"></i>
    </a>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
             class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
             class="fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @stack('scripts')
</body>
</html>
