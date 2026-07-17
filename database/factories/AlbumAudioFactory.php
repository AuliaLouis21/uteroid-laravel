<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumAudio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlbumAudioFactory extends Factory
{
    protected $model = AlbumAudio::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'album_id' => Album::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'filename' => fake()->uuid() . '.mp3',
            'description' => fake()->paragraph(),
        ];
    }
}
