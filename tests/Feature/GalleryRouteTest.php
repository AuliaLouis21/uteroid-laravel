<?php

namespace Tests\Feature;

use App\Models\Album;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GalleryRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_index_returns_200(): void
    {
        $response = $this->get(route('gallery.index'));

        $response->assertOk();
    }

    public function test_gallery_photos_returns_200(): void
    {
        $album = Album::factory()->create();

        $response = $this->get(route('gallery.photos', $album->slug));

        $response->assertOk();
    }

    public function test_gallery_videos_returns_200(): void
    {
        $response = $this->get(route('gallery.videos'));

        $response->assertOk();
    }
}
