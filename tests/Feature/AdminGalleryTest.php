<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createGallery(array $overrides = []): Gallery
    {
        return Gallery::factory()->create($overrides);
    }

    public function test_admin_gallery_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.galleries.index'));

        $response->assertOk();
    }

    public function test_admin_gallery_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.galleries.create'));

        $response->assertOk();
    }

    public function test_admin_gallery_store_creates_gallery(): void
    {
        $category = \App\Models\Category::factory()->create();

        $data = [
            'title' => 'Test Gallery',
            'slug' => 'test-gallery',
            'description' => 'A test gallery description.',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.galleries.store'), $data);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', ['title' => 'Test Gallery']);
    }

    public function test_admin_gallery_show_returns_200(): void
    {
        $gallery = $this->createGallery();

        $response = $this->actingAs($this->user)->get(route('admin.galleries.show', $gallery));

        $response->assertOk();
    }

    public function test_admin_gallery_edit_returns_200(): void
    {
        $gallery = $this->createGallery();

        $response = $this->actingAs($this->user)->get(route('admin.galleries.edit', $gallery));

        $response->assertOk();
    }

    public function test_admin_gallery_update_updates_gallery(): void
    {
        $gallery = $this->createGallery(['title' => 'Old Title']);

        $data = [
            'title' => 'Updated Gallery Title',
            'slug' => $gallery->slug,
            'description' => $gallery->description,
            'category_id' => $gallery->category_id,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.galleries.update', $gallery), $data);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', ['id' => $gallery->id, 'title' => 'Updated Gallery Title']);
    }

    public function test_admin_gallery_destroy_deletes_gallery(): void
    {
        $gallery = $this->createGallery();

        $response = $this->actingAs($this->user)->delete(route('admin.galleries.destroy', $gallery));

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    }
}
