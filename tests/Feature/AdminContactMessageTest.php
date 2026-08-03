<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactMessageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createMessage(array $overrides = []): ContactMessage
    {
        return ContactMessage::factory()->create($overrides);
    }

    public function test_admin_contact_message_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.contact-messages.index'));

        $response->assertOk();
    }

    public function test_admin_contact_message_index_filters_by_status(): void
    {
        $this->createMessage(['status' => 'new']);
        $this->createMessage(['status' => 'replied']);

        $response = $this->actingAs($this->user)->get(route('admin.contact-messages.index', ['status' => 'replied']));

        $response->assertOk();
        $response->assertSee('Replied');
    }

    public function test_admin_contact_message_show_returns_200(): void
    {
        $message = $this->createMessage();

        $response = $this->actingAs($this->user)->get(route('admin.contact-messages.show', $message));

        $response->assertOk();
    }

    public function test_admin_contact_message_update_updates_status(): void
    {
        $message = $this->createMessage(['status' => 'new']);

        $response = $this->actingAs($this->user)->put(route('admin.contact-messages.update', $message), [
            'status' => 'read',
        ]);

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertDatabaseHas('contact_messages', ['id' => $message->id, 'status' => 'read']);
    }

    public function test_admin_contact_message_destroy_deletes_message(): void
    {
        $message = $this->createMessage();

        $response = $this->actingAs($this->user)->delete(route('admin.contact-messages.destroy', $message));

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
