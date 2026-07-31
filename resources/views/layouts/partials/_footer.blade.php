<div class="footer-area">
    <div class="site-wrapper" style="padding-top:64px;padding-bottom:64px">
        <div class="footer-grid" style="display:grid;gap:32px">
            {{-- Kolom 1: Who We Are --}}
            <div class="footer-col">
                <div class="footer-label"><i class="fas fa-building mr-2"></i>Who We Are?</div>
                <div class="footer-text" style="margin-bottom:16px">
                    Suatu perusahaan yang bergerak dalam bidang jasa dan produk periklanan,
                    idea dan concept yang konsisten dalam membantu para kliennya untuk
                    mewujudkan nilai-nilai penjualan yang maksimal.
                    <a href="{{ route('pages.show', 'tentang-kami') }}" title="About Us" style="display:block;margin-top:8px">read more <i class="fas fa-arrow-right"></i></a>
                </div>
                <div style="display:flex;gap:12px;align-items:center">
                    <a href="https://www.tiktok.com/@uteroindonesia" target="_blank" rel="noopener noreferrer" title="TikTok" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.youtube.com/channel/UCkdJC5Tw0bk0xK9sUR80xnA" target="_blank" rel="noopener noreferrer" title="YouTube" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.youtube.com/channel/UC--Vge6YlX1y65HqjqYP8uQ" target="_blank" rel="noopener noreferrer" title="YouTube 2" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="https://x.com/uteroindonesia" target="_blank" rel="noopener noreferrer" title="X (Twitter)" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/uteroindonesia" target="_blank" rel="noopener noreferrer" title="Instagram" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/uteroadvertisingindonesia" target="_blank" rel="noopener noreferrer" title="Facebook" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            {{-- Kolom 2: Lokasi Kami --}}
            <div class="footer-col">
                <div class="footer-label"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kami</div>
                <div style="border-radius:8px;overflow:hidden;margin-bottom:16px;border:1px solid rgba(255,255,255,.1)">
                    <iframe loading="lazy" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2886993069!2d112.6317828409092!3d-7.9786290600267975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629c5e8a20281%3A0x3ff201ddaa440c96!2sPT%20UTERO%20KREATIF%20INDONESIA!5e0!3m2!1sen!2sid!4v1696298771980!5m2!1sen!2sid" width="100%" height="180" style="border:0;border-radius:8px" allowfullscreen title="Lokasi Utero Advertising"></iframe>
                </div>
            </div>

            {{-- Kolom 3: Testimonial --}}
            <div class="footer-col">
                <div class="footer-label"><i class="fas fa-quote-left mr-2"></i>Testimonial <a href="{{ route('testimonials.index') }}" style="font-size:12px">Read More <i class="fas fa-arrow-right"></i></a></div>
                @php
                $randomTestimonial = \Illuminate\Support\Facades\Cache::remember('random_approved_testimonial', 3600, fn() => \App\Models\Testimonial::where('status', 'approved')->inRandomOrder()->first());
                @endphp
                @if($randomTestimonial)
                <div class="testimonial-card">
                    <div class="testimonial-text">{{ ucfirst($randomTestimonial->content) }}</div>
                    <div class="testimonial-stars" aria-label="Rating {{ $randomTestimonial->rating }} dari 5">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="testimonial-star {{ $i <= $randomTestimonial->rating ? 'is-filled' : 'is-empty' }}" aria-hidden="true">&#9733;</span>
                        @endfor
                    </div>
                    <div class="testimonial-info">From: {{ $randomTestimonial->name }} &rarr; {{ $randomTestimonial->created_at->format('M d, Y') }}</div>
                </div>
                @else
                <p style="color:#9ca3af;font-size:14px">Belum ada testimonial.</p>
                @endif
            </div>

            {{-- Kolom 4: Contact Us --}}
            <div class="footer-col">
                <div class="footer-label"><i class="fas fa-phone mr-2"></i>Contact Us</div>
                <div class="footer-text">
                    <p style="font-weight:600;color:#fff;margin-bottom:4px">PT. UTERO KREATIF INDONESIA</p>
                    <p style="font-size:12px;color:#9ca3af;margin-bottom:12px">RUMAH MERAH OXYZ</p>
                    <div style="display:flex;flex-direction:column;gap:8px;font-size:14px">
                        <p><i class="fas fa-map-pin mr-2 text-brand"></i>Jl. Bantaran 1 No. 25, Tulusrejo, Lowokwaru, Malang 65141</p>
                        <p><i class="fas fa-phone mr-2 text-brand"></i>0341 408408</p>
                        <p><i class="fab fa-whatsapp mr-2 text-brand"></i>+62 819-9990-0900 (Pak Dadik)</p>
                        <p><i class="fas fa-envelope mr-2 text-brand"></i>marketingutero@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright">
        <div class="site-wrapper" style="display:flex;justify-content:space-between;align-items:center">
            <span>&copy; 2009-{{ date('Y') }} uterogroup.com, All Right Reserved</span>
            <span style="color:#9ca3af;font-size:12px">Idea And Concept Factory</span>
        </div>
    </div>
</div>
