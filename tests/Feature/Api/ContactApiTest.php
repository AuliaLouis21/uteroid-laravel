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

    public function test_contact_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/contact', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);
    }
}
