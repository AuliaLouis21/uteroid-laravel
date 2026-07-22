<?php

namespace Tests\Feature;

use App\Models\Page;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_page_returns_200(): void
    {
        $page = Page::factory()->create(['slug' => 'tentang-kami']);

        $response = $this->get(route('pages.show', $page->slug));

        $response->assertOk();
        $response->assertSee($page->title);
    }

    public function test_static_page_returns_404_for_invalid_slug(): void
    {
        $response = $this->get(route('pages.show', 'halaman-tidak-ada'));

        $response->assertNotFound();
    }

    public function test_static_page_displays_content(): void
    {
        $page = Page::factory()->create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => '<p>PT. Utero Kreatif Indonesia adalah perusahaan advertising.</p>',
        ]);

        $response = $this->get(route('pages.show', $page->slug));

        $response->assertOk();
        $response->assertSee('PT. Utero Kreatif Indonesia');
    }
}
