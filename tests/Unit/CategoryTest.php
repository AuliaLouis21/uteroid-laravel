<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_has_many_galleries(): void
    {
        $category = Category::factory()->create();

        Gallery::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->galleries);
        $this->assertInstanceOf(Gallery::class, $category->galleries->first());
    }

    public function test_category_has_many_posts(): void
    {
        $category = Category::factory()->create();

        News::factory()->count(4)->create(['category_id' => $category->id]);

        $this->assertCount(4, $category->posts);
        $this->assertInstanceOf(News::class, $category->posts->first());
    }

    public function test_category_has_correct_fillable_fields(): void
    {
        $category = new Category();

        $this->assertEquals(['name', 'slug'], $category->getFillable());
    }
}
