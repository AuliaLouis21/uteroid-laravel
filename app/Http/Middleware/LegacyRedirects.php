<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LegacyRedirects
{
    private array $redirects = [
        'pertamax'    => '/',
        'home'        => '/',
        'produk'      => '/produk',
        'news'        => '/berita',
        'gallery'     => '/galeri',
        'foto'        => '/galeri',
        'video'       => '/galeri',
        'audio'       => '/galeri',
        'testimonial' => '/testimonial',
        'order'       => '/order',
        'contact'     => '/kontak',
        'download'    => '/download',
        'ads'         => '/',
        'signup'      => '/register',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $t = $request->query('t');

        if ($t && isset($this->redirects[$t])) {
            return redirect($this->redirects[$t], 301);
        }

        if ($request->is('index.php')) {
            return redirect('/', 301);
        }

        return $next($request);
    }
}
