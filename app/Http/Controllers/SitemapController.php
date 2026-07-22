<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Album;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = config('app.url', 'https://uterogroup.com');

        $pages = collect([
            route('home', [], false),
            route('products.index', [], false),
            route('posts.index', [], false),
            route('gallery.index', [], false),
            route('testimonials.index', [], false),
            route('contact.index', [], false),
            route('order.create', [], false),
        ]);

        $products = Product::pluck('slug')->map(fn($slug) => route('products.show', $slug, false));
        $categories = ProductCategory::pluck('slug')->map(fn($slug) => route('products.category', $slug, false));
        $posts = News::pluck('slug')->map(fn($slug) => route('posts.show', $slug, false));
        $albums = Album::pluck('slug')->map(fn($slug) => route('gallery.photos', $slug, false));
        $staticPages = Page::pluck('slug')->map(fn($slug) => route('pages.show', $slug, false));

        $allUrls = $pages->concat($products)->concat($categories)->concat($posts)->concat($albums)->concat($staticPages);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($allUrls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . e($baseUrl . $url) . '</loc>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>0.8</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
