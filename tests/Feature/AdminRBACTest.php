<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRBACTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_all_admin_resources(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $routes = [
            'admin.news.index',
            'admin.products.index',
            'admin.pages.index',
            'admin.categories.index',
            'admin.galleries.index',
            'admin.testimonials.index',
            'admin.orders.index',
            'admin.advertisements.index',
            'admin.product-categories.index',
            'admin.albums.index',
            'admin.videos.index',
            'admin.audio.index',
            'admin.settings.edit',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($admin)->get(route($routeName));
            $response->assertOk();
        }
    }

    public function test_editor_can_access_admin_resources(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $routes = [
            'admin.news.index',
            'admin.products.index',
            'admin.pages.index',
            'admin.testimonials.index',
            'admin.orders.index',
            'admin.settings.edit',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($editor)->get(route($routeName));
            $response->assertOk();
        }
    }

    public function test_viewer_cannot_access_admin(): void
    {
        $viewer = User::factory()->create(['role' => 'viewer']);

        $response = $this->actingAs($viewer)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_viewer_cannot_access_admin_resources(): void
    {
        $viewer = User::factory()->create(['role' => 'viewer']);

        $routes = [
            'admin.news.index',
            'admin.products.index',
            'admin.pages.index',
            'admin.orders.index',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($viewer)->get(route($routeName));
            $response->assertStatus(403);
        }
    }

    public function test_unauthenticated_user_cannot_access_admin_resources(): void
    {
        $routes = [
            'admin.news.index',
            'admin.products.index',
            'admin.pages.index',
            'admin.orders.index',
            'admin.testimonials.index',
        ];

        foreach ($routes as $routeName) {
            $response = $this->get(route($routeName));
            $response->assertRedirect(route('login'));
        }
    }
}
