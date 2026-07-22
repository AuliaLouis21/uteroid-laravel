<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminNewsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createNews(array $overrides = []): News
    {
        $title = fake()->sentence();

        return News::create(array_merge([
            'title' => $title,
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'published_at' => now()->toDateString(),
        ], $overrides));
    }

    public function test_admin_news_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.news.index'));

        $response->assertOk();
    }

    public function test_admin_news_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.news.create'));

        $response->assertOk();
    }

    public function test_admin_news_store_creates_news(): void
    {
        $data = [
            'title' => 'Breaking News Title',
            'slug' => 'breaking-news-title',
            'excerpt' => 'This is an excerpt.',
            'content' => 'Full news content goes here.',
            'published_at' => now()->toDateString(),
        ];

        $response = $this->actingAs($this->user)->post(route('admin.news.store'), $data);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('posts', ['title' => 'Breaking News Title']);
    }

    public function test_admin_news_show_returns_200(): void
    {
        $news = $this->createNews();

        $response = $this->actingAs($this->user)->get(route('admin.news.show', $news));

        $response->assertOk();
    }

    public function test_admin_news_edit_returns_200(): void
    {
        $news = $this->createNews();

        $response = $this->actingAs($this->user)->get(route('admin.news.edit', $news));

        $response->assertOk();
    }

    public function test_admin_news_update_updates_news(): void
    {
        $news = $this->createNews(['title' => 'Old Title']);

        $data = [
            'title' => 'Updated News Title',
            'slug' => $news->slug,
            'excerpt' => 'Updated excerpt.',
            'content' => 'Updated content.',
        ];

        $response = $this->actingAs($this->user)->put(route('admin.news.update', $news), $data);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('posts', ['id' => $news->id, 'title' => 'Updated News Title']);
    }

    public function test_admin_news_destroy_deletes_news(): void
    {
        $news = $this->createNews();

        $response = $this->actingAs($this->user)->delete(route('admin.news.destroy', $news));

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('posts', ['id' => $news->id]);
    }
}
