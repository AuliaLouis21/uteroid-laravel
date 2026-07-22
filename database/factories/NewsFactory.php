<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numerify('###'),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'category_id' => Category::factory(),
            'published_at' => now(),
        ];
    }
}
