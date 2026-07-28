<?php

namespace Tests\Feature\Api;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\AlbumVideo;
use App\Models\AlbumAudio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_index_returns_albums(): void
    {
        Album::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/gallery');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'photos_count'],
                ],
            ]);
    }

    public function test_gallery_photos_returns_album_with_photos(): void
    {
        $album = Album::factory()->create(['slug' => 'office']);
        AlbumPhoto::factory()->count(3)->create(['album_id' => $album->id]);

        $response = $this->getJson('/api/v1/gallery/photos/office');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'photos'],
            ]);
    }

    public function test_gallery_photos_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/v1/gallery/photos/non-existent');

        $response->assertNotFound()
            ->assertJson(['message' => 'Album not found']);
    }

    public function test_gallery_videos_returns_paginated_json(): void
    {
        AlbumVideo::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/gallery/videos');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'slug', 'url'],
                ],
            ]);
    }

    public function test_gallery_audios_returns_paginated_json(): void
    {
        AlbumAudio::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/gallery/audios');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'slug', 'filename'],
                ],
            ]);
    }
}
