<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Description" content="advertising malang,perusahaan advertising,utero advertising,printing,art,concept,malang">
    <meta name="Robots" content="Index, Follow">
    <title>@yield('title', 'Utero Advertising | Idea And Concept Factory')</title>
    <link rel="icon" type="image/x-icon" href="/images/utero.ico">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="m-0 p-0">
    <div id="header">
        <div class="site-wrapper" style="height:100%;">&nbsp;</div>
    </div>

    <div class="nav-bar">
        <div id="menubar" class="site-wrapper">
            <ul>
                <li><a href="{{ route('home') }}" title="Home" style="border-left:none;" {{ request()->routeIs('home') ? 'class=active' : '' }}>HOME</a></li>
                <li><a href="{{ route('products.index') }}" title="Product" {{ request()->routeIs('products.*') ? 'class=active' : '' }}>PRICE</a></li>
                @foreach($staticPages as $sp)
                    <li><a href="{{ route('pages.show', $sp->slug) }}" title="{{ $sp->title }}" {{ request()->routeIs('pages.show') && request('slug') == $sp->slug ? 'class=active' : '' }}>{{ strtoupper($sp->title) }}</a></li>
                @endforeach
                <li><a href="{{ route('gallery.index') }}" title="Gallery" style="border-right:none;" {{ request()->routeIs('gallery.*') ? 'class=active' : '' }}>GALLERY</a></li>
                <li><a href="{{ route('posts.index') }}" title="News" {{ request()->routeIs('posts.*') ? 'class=active' : '' }}>NEWS</a></li>
                <li><a href="{{ route('testimonials.index') }}" title="Testimonial" {{ request()->routeIs('testimonials.*') ? 'class=active' : '' }}>TESTIMONIAL</a></li>
            </ul>
        </div>
    </div>

    <div id="body" class="overflow-hidden">
        @php
            $tickerPosts = \App\Models\News::latest()->take(10)->get();
            $tickerItems = $tickerPosts->map(function($p) {
                $date = $p->published_at ? $p->published_at->format('F jS, Y') : $p->created_at->format('F jS, Y');
                $url = route('posts.show', $p->slug);
                $title = e(ucwords($p->title));
                return "$date : <a href=\"$url\" title=\"$title\">$title</a>";
            })->values();
        @endphp
        <div class="news-ticker"
             x-data="ticker()"
             x-init="init()"
             @@mouseenter="pause = true"
             @@mouseleave="pause = false">
            <ul>
                <template x-for="(item, i) in items" :key="i">
                    <li x-show="current === i" x-transition:enter="transition ease-in duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <span x-html="item"></span>
                    </li>
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
                    <img src="/images/new-fb.png" height="45" width="300" alt="Find us on Facebook" style="border:none;padding-bottom:15px;">
                </a>
                <a href="https://x.com/uteroindonesia" target="_blank" title="Follow us on Twitter">
                    <img src="/images/new-twitter.png" height="45" width="300" alt="Follow us on Twitter" style="border:none;padding-bottom:15px;">
                </a>
                <a href="http://instagram.com/uteroindonesia" target="_blank" title="Find us on Instagram">
                    <img src="/images/new-instagram.png" height="45" width="300" alt="Find us on Instagram" style="border:none;padding-bottom:15px;">
                </a>
                <a href="https://www.youtube.com/channel/UCkdJC5Tw0bk0xK9sUR80xnA" target="_blank" title="Find us on Youtube">
                    <img src="/images/new-youtube.png" height="45" width="300" alt="Find us on Youtube" style="border:none;padding-bottom:15px;">
                </a>
                <a href="https://www.youtube.com/channel/UC--Vge6YlX1y65HqjqYP8uQ" target="_blank" title="Find us on Youtube">
                    <img src="/images/new-youtube2.png" height="45" width="300" alt="Find us on Youtube" style="border:none;padding-bottom:15px;">
                </a>
            </div>
            <div class="footer-col3">
                <div class="footer-text">
                    <center>
                        <div class="footer-label">Contact Us</div>
                        PT. UTERO KREATIF INDONESIA
                    </center><br>
                    <div class="footer-label"><center>RUMAH MERAH OXYZ</center></div>
                    <center>
                        Jalan Bantaran 1 No. 25<br>
                        Tulusrejo, Kec. Lowokwaru<br>
                        Malang - Jawa Timur<br>
                        Indonesia<br>65141<br><br>
                        <b>No. Telpon</b><br>0341 408408<br><br>
                        <b>WhatsApp</b><br>
                        081 999 900 900 (wahyu)<br>
                        081 7388 616 (utero)<br><br>
                        <b>Email</b><br>marketingutero@gmail.com<br><br>
                    </center>
                </div>
            </div>
            <div class="footer-col2">
                <div class="footer-text">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2886993069!2d112.6317828409092!3d-7.9786290600267975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629c5e8a20281%3A0x3ff201ddaa440c96!2sPT%20UTERO%20KREATIF%20INDONESIA!5e0!3m2!1sen!2sid!4v1696298771980!5m2!1sen!2sid" width="250" height="270" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <br>
                <div class="footer-label">Testimonial &raquo;
                    <a href="{{ route('testimonials.index') }}">Read More &rarr;</a>
                </div>
                @php
                    $randomTestimonial = \App\Models\Testimonial::where('status', 'approved')->inRandomOrder()->first();
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

    <a href="https://wa.me/6281999900900?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" class="whatsapp-btn" target="_blank">
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

    <script>
        function ticker() {
            return {
                items: @json($tickerItems),
                current: 0,
                pause: false,
                timer: null,
                init() {
                    this.start();
                },
                start() {
                    if (this.timer) clearInterval(this.timer);
                    this.timer = setInterval(() => {
                        if (!this.pause) {
                            this.current = (this.current + 1) % this.items.length;
                        }
                    }, 4000);
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
