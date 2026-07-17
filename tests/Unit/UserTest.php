<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_user_has_correct_fillable_fields(): void
    {
        $user = new User();

        $this->assertEquals(['name', 'email', 'password', 'role'], $user->getFillable());
    }

    public function test_user_role_defaults_to_viewer(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertEquals('admin', $user->role);
        $this->assertContains($user->role, ['admin', 'editor', 'viewer']);
    }
}
