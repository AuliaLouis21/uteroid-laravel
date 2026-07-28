<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * How long (seconds) to cache GET responses.
     */
    protected int $ttl = 300;

    /**
     * URI patterns to exclude from caching (admin, auth, POST, etc.).
     */
    protected array $except = [
        'admin',
        'login',
        'register',
        'password',
        'profile',
        'dashboard',
        'api',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() !== 'GET' || $request->ajax()) {
            return $next($request);
        }

        foreach ($this->except as $pattern) {
            if (str_contains($request->path(), $pattern)) {
                return $next($request);
            }
        }

        $cacheKey = 'response.' . md5($request->fullUrl());

        if ($cached = Cache::get($cacheKey)) {
            return response($cached['content'])
                ->headers($cached['headers'])
                ->setStatusCode(200);
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200) {
            Cache::put($cacheKey, [
                'content' => $response->getContent(),
                'headers' => [
                    'Content-Type' => $response->headers->get('Content-Type', 'text/html'),
                ],
            ], $this->ttl);
        }

        return $response;
    }
}
