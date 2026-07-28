@props(['src', 'alt' => '', 'class' => '', 'width' => null, 'height' => null, 'loading' => 'lazy'])

@php
    // Generate WebP path by replacing extension
    $webpSrc = preg_replace('/\.(jpe?g|png|gif)$/i', '.webp', $src);
    $originalExt = strtolower(pathinfo($src, PATHINFO_EXTENSION));
@endphp

<picture>
    {{-- WebP source for browsers that support it --}}
    @if(in_array($originalExt, ['jpg', 'jpeg', 'png', 'gif']))
        <source srcset="{{ $webpSrc }}" type="image/webp">
    @endif

    {{-- Original format fallback --}}
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="{{ $class }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        loading="{{ $loading }}"
        decoding="async"
    >
</picture>
