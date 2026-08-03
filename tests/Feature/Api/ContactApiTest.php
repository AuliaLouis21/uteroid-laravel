<?php

namespace Tests\Feature\Api;

use App\Mail\ContactMessageMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_store_sends_email(): void
    {
        Mail::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about services',
            'message' => 'I would like to know more about your services.',
        ];

        $response = $this->postJson('/api/v1/contact', $data);

        $response->assertCreated()
            ->assertJson(['message' => 'Message sent successfully. We will respond shortly.']);

        Mail::assertQueued(ContactMessageMail::class);
    }

    public function test_contact_store_stores_message_to_cms(): void
    {
        $data = [
            'name' => 'API User',
            'email' => 'api@example.com',
            'phone' => '08123456789',
            'subject' => 'Inquiry about services',
            'message' => 'I would like to know more about your services.',
        ];

        $response = $this->postJson('/api/v1/contact', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'API User',
            'email' => 'api@example.com',
            'phone' => '08123456789',
            'subject' => 'Inquiry about services',
            'message' => 'I would like to know more about your services.',
            'status' => 'new',
        ]);
    }

    public function test_contact_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/contact', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);
    }
}
