<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createPage(array $overrides = []): Page
    {
        return Page::factory()->create($overrides);
    }

    public function test_admin_page_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.pages.index'));

        $response->assertOk();
    }

    public function test_admin_page_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.pages.create'));

        $response->assertOk();
    }

    public function test_admin_page_store_creates_page(): void
    {
        $data = [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'content' => 'This is a test page content.',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.pages.store'), $data);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['title' => 'Test Page']);
    }

    public function test_admin_page_show_returns_200(): void
    {
        $page = $this->createPage();

        $response = $this->actingAs($this->user)->get(route('admin.pages.show', $page));

        $response->assertOk();
    }

    public function test_admin_page_edit_returns_200(): void
    {
        $page = $this->createPage();

        $response = $this->actingAs($this->user)->get(route('admin.pages.edit', $page));

        $response->assertOk();
    }

    public function test_admin_page_update_updates_page(): void
    {
        $page = $this->createPage(['title' => 'Old Title']);

        $data = [
            'title' => 'Updated Page Title',
            'slug' => $page->slug,
            'content' => $page->content,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.pages.update', $page), $data);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Updated Page Title']);
    }

    public function test_admin_page_destroy_deletes_page(): void
    {
        $page = $this->createPage();

        $response = $this->actingAs($this->user)->delete(route('admin.pages.destroy', $page));

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
