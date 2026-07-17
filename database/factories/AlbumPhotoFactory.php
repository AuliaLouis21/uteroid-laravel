<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumPhotoFactory extends Factory
{
    protected $model = AlbumPhoto::class;

    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'filename' => fake()->uuid() . '.jpg',
            'caption' => fake()->sentence(),
        ];
    }
}
