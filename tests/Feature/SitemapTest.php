<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_200(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_sitemap_contains_valid_xml(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $content = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0"', $content);
        $this->assertStringContainsString('<urlset xmlns=', $content);
        $this->assertStringContainsString('</urlset>', $content);
    }

    public function test_sitemap_contains_static_routes(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertSee(route('home', [], false));
        $response->assertSee(route('products.index', [], false));
        $response->assertSee(route('posts.index', [], false));
        $response->assertSee(route('gallery.index', [], false));
        $response->assertSee(route('contact.index', [], false));
    }

    public function test_sitemap_contains_products(): void
    {
        $product = Product::factory()->create(['slug' => 'box-kardus']);

        $response = $this->get(route('sitemap'));

        $response->assertSee('box-kardus');
    }

    public function test_sitemap_contains_news_posts(): void
    {
        $post = News::factory()->create(['slug' => 'berita-terbaru']);

        $response = $this->get(route('sitemap'));

        $response->assertSee('berita-terbaru');
    }
}
