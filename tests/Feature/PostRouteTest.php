<?php

namespace Tests\Feature;

use App\Models\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_index_returns_200(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertOk();
    }

    public function test_post_show_returns_200(): void
    {
        $post = News::factory()->create();

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
    }

    public function test_post_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->get(route('posts.show', 'berita-tidak-ditemukan'));

        $response->assertNotFound();
    }
}
