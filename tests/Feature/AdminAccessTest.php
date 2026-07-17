<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_to_login_when_accessing_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
    }

    public function test_editor_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'editor']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
    }

    public function test_viewer_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }
}
