<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_200(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }

    public function test_homepage_displays_products_and_news(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'is_promo' => true,
            'size' => '10x20',
            'unit_price' => 50000,
        ]);
        $news = News::factory()->create(['published_at' => now()]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee($product->name);
        $response->assertSee($news->title);
    }
}
