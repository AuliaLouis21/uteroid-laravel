<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\AlbumAudio;
use App\Models\AlbumPhoto;
use App\Models\AlbumVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_album_has_many_photos(): void
    {
        $album = Album::factory()->create();

        AlbumPhoto::factory()->count(4)->create(['album_id' => $album->id]);

        $this->assertCount(4, $album->photos);
        $this->assertInstanceOf(AlbumPhoto::class, $album->photos->first());
    }

    public function test_album_has_many_videos(): void
    {
        $album = Album::factory()->create();

        AlbumVideo::factory()->count(2)->create(['album_id' => $album->id]);

        $this->assertCount(2, $album->videos);
        $this->assertInstanceOf(AlbumVideo::class, $album->videos->first());
    }

    public function test_album_has_many_audios(): void
    {
        $album = Album::factory()->create();

        AlbumAudio::factory()->count(3)->create(['album_id' => $album->id]);

        $this->assertCount(3, $album->audios);
        $this->assertInstanceOf(AlbumAudio::class, $album->audios->first());
    }
}
