@extends('layouts.frontend')

@section('title', $album->name . ' | Galeri | Utero Advertising')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
@php
$galleryPhotos = $album->photos->map(fn($p) => [
    'id' => $p->id,
    'src' => asset('storage/' . $p->filename),
    'caption' => $p->caption ?? null,
])->values();
@endphp
<div class="py-6" x-data="galleryLightbox()">
    <div class="content-card">
        <a href="{{ route('gallery.index') }}" class="text-sm text-brand no-underline hover:text-white mb-4 inline-block">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Gallery
        </a>
        <div class="page-title">{{ $album->name }}</div>
        <div class="page-title-bar"></div>
        @if($album->description)
            <p class="text-gray-500 mb-6">{{ $album->description }}</p>
        @endif

        <div class="gallery-grid">
            @forelse($album->photos as $photo)
                <div class="gallery-item cursor-pointer" @click="open({{ $photo->id }})" role="button" tabindex="0" @keydown.enter="open({{ $photo->id }})" :aria-label="'Lihat foto: ' + captionOf({{ $photo->id }})">
                    <div class="img" style="height: auto;">
                        <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption ?? $album->name }}" loading="lazy" class="w-full object-cover" style="height: 220px;">
                    </div>
                    @if($photo->caption)
                        <div class="desc">{{ $photo->caption }}</div>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-center py-8"><i class="fas fa-images text-2xl mb-2 block"></i>Album ini belum memiliki foto.</p>
            @endforelse
        </div>
    </div>

    {{-- Lightbox: gambar kiri, keterangan kanan --}}
    <div x-show="active" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8" style="background: rgba(0,0,0,.88);" @keydown.escape.window="close()">
        <button type="button" @click="close()" aria-label="Tutup" class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl z-10" style="background:none;border:none;cursor:pointer">
            <i class="fas fa-times"></i>
        </button>

        <div class="relative w-full max-w-5xl bg-white rounded-xl overflow-hidden shadow-2xl flex flex-col md:flex-row max-h-[90vh]">
            {{-- Image --}}
            <div class="relative md:flex-1 bg-black flex items-center justify-center min-h-[260px]">
                <img :src="active ? active.src : ''" :alt="active ? active.caption : ''" class="w-full h-full object-contain" style="max-height: 90vh;">

                <button type="button" @click="prev()" aria-label="Foto sebelumnya" x-show="photos.length > 1" class="absolute left-3 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-2xl px-2" style="background:rgba(0,0,0,.35);border:none;border-radius:8px;cursor:pointer">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" @click="next()" aria-label="Foto berikutnya" x-show="photos.length > 1" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-2xl px-2" style="background:rgba(0,0,0,.35);border:none;border-radius:8px;cursor:pointer">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            {{-- Keterangan --}}
            <div class="w-full md:w-80 shrink-0 p-6 overflow-y-auto" style="background:#fff">
                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Keterangan
                </div>
                <h3 class="text-lg font-semibold text-black mb-2">{{ $album->name }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed" x-text="active ? (active.caption || 'Tanpa keterangan.') : ''"></p>

                <template x-if="photos.length > 1">
                    <div class="mt-4 pt-4 text-xs text-gray-400" style="border-top:1px solid #eee">
                        <span x-text="(currentIndex + 1) + ' / ' + photos.length"></span> foto
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var galleryPhotos = @json($galleryPhotos);

function galleryLightbox() {
    return {
        photos: galleryPhotos,
        active: null,
        open(id) {
            this.active = this.photos.find(function (p) { return p.id === id; }) || null;
        },
        close() {
            this.active = null;
        },
        next() {
            this.move(1);
        },
        prev() {
            this.move(-1);
        },
        move(dir) {
            if (!this.photos.length) return;
            var idx = this.currentIndex;
            var nextIdx = (idx + dir + this.photos.length) % this.photos.length;
            this.active = this.photos[nextIdx];
        },
        captionOf(id) {
            var p = this.photos.find(function (x) { return x.id === id; });
            return p ? (p.caption || 'Tanpa keterangan.') : '';
        },
        get currentIndex() {
            if (!this.active) return 0;
            return this.photos.findIndex(function (p) { return p.id === this.active.id; }.bind(this));
        }
    }
}
</script>
@endpush