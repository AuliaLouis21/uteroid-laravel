<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumVideo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlbumVideoFactory extends Factory
{
    protected $model = AlbumVideo::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'album_id' => Album::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'url' => 'https://www.youtube.com/watch?v=' . fake()->uuid(),
            'description' => fake()->paragraph(),
        ];
    }
}
