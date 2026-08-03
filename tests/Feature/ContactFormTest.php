<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_returns_200(): void
    {
        $response = $this->get(route('contact.index'));

        $response->assertOk();
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_stores_message_to_cms(): void
    {
        Mail::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_sends_email(): void
    {
        Mail::fake();

        $data = [
            'name' => 'Email Test',
            'email' => 'email@test.com',
            'subject' => 'Test Subject',
            'message' => 'Hello.',
        ];

        $this->post(route('contact.send'), $data);

        Mail::assertQueued(ContactMessageMail::class, function ($mail) {
            return $mail->hasTo(config('mail.from.address'));
        });
    }
}
