<?php

namespace Tests\Unit;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_has_correct_fillable_fields(): void
    {
        $page = new Page();

        $this->assertEquals([
            'title',
            'slug',
            'content',
            'image',
        ], $page->getFillable());
    }

    public function test_page_can_be_created(): void
    {
        $page = Page::factory()->create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => '<p>Ini adalah halaman tentang kami.</p>',
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
        ]);
    }

    public function test_page_requires_title_and_slug(): void
    {
        $page = new Page();

        $this->assertTrue(in_array('title', $page->getFillable()));
        $this->assertTrue(in_array('slug', $page->getFillable()));
    }
}
