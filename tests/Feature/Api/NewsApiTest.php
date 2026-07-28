<?php

namespace Tests\Feature\Api;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_returns_paginated_json(): void
    {
        News::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/news');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'slug', 'excerpt', 'content', 'image'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_news_index_filters_by_search(): void
    {
        News::factory()->create(['title' => 'Utero Group Opening']);
        News::factory()->create(['title' => 'New Product Launch']);
        News::factory()->create(['title' => 'Company Profile']);

        $response = $this->getJson('/api/v1/news?search=Opening');

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_news_show_returns_single_post(): void
    {
        $post = News::factory()->create(['slug' => 'uterogroup-opening']);

        $response = $this->getJson('/api/v1/news/uterogroup-opening');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'title', 'slug', 'excerpt', 'content'],
            ]);
    }

    public function test_news_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/v1/news/non-existent');

        $response->assertNotFound()
            ->assertJson(['message' => 'News not found']);
    }
}
