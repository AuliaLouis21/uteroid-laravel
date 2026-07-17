<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Berita']);
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }

    public function test_post_has_correct_fillable_fields(): void
    {
        $post = new Post();

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
