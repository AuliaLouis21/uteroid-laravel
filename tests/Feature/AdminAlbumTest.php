<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAlbumTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createAlbum(array $overrides = []): Album
    {
        return Album::factory()->create($overrides);
    }

    public function test_admin_album_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.albums.index'));

        $response->assertOk();
    }

    public function test_admin_album_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.albums.create'));

        $response->assertOk();
    }

    public function test_admin_album_store_creates_album(): void
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Test Album',
            'slug' => 'test-album',
            'description' => 'A test album description.',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.albums.store'), $data);

        $response->assertRedirect(route('admin.albums.index'));
        $this->assertDatabaseHas('albums', ['name' => 'Test Album']);
    }

    public function test_admin_album_show_returns_200(): void
    {
        $album = $this->createAlbum();

        $response = $this->actingAs($this->user)->get(route('admin.albums.show', $album));

        $response->assertOk();
    }

    public function test_admin_album_edit_returns_200(): void
    {
        $album = $this->createAlbum();

        $response = $this->actingAs($this->user)->get(route('admin.albums.edit', $album));

        $response->assertOk();
    }

    public function test_admin_album_update_updates_album(): void
    {
        $album = $this->createAlbum(['name' => 'Old Name']);

        $data = [
            'name' => 'Updated Album Name',
            'slug' => $album->slug,
            'description' => $album->description,
            'category_id' => $album->category_id,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.albums.update', $album), $data);

        $response->assertRedirect(route('admin.albums.index'));
        $this->assertDatabaseHas('albums', ['id' => $album->id, 'name' => 'Updated Album Name']);
    }

    public function test_admin_album_destroy_deletes_album(): void
    {
        $album = $this->createAlbum();

        $response = $this->actingAs($this->user)->delete(route('admin.albums.destroy', $album));

        $response->assertRedirect(route('admin.albums.index'));
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }
}
