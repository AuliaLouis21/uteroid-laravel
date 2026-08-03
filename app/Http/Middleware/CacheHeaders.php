<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response instanceof Response) {
            $noStoreRouteNames = [
                'login',
                'register',
                'password.request',
                'password.reset',
                'password.confirm',
                'verification.notice',
                'contact.index',
                'order.create',
                'testimonials.index',
            ];

            if ($request->user()
                || $request->is('admin/*')
                || $request->route()?->named($noStoreRouteNames)) {
                $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            } else {
                $response->headers->set('Cache-Control', 'public, max-age=3600, s-maxage=3600');
            }
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        return $response;
    }
}
