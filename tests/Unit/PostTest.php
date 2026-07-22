<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Berita']);
        $post = News::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }

    public function test_post_has_correct_fillable_fields(): void
    {
        $post = new News();

        $this->assertEquals([
            'title',
            'slug',
            'excerpt',
            'content',
            'image',
            'category_id',
            'published_at',
        ], $post->getFillable());
    }
}
