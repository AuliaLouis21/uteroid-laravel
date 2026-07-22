<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class FormSubmissionTest extends TestCase
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

    public function test_contact_form_successfully_submits(): void
    {
        Mail::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');
    }

    public function test_testimonial_form_validates_required_fields(): void
    {
        $response = $this->post(route('testimonials.store'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'content']);
    }

    public function test_testimonial_form_successfully_submits(): void
    {
        $data = [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'company' => 'Acme Corp',
            'content' => 'Great product, highly recommended!',
        ];

        $response = $this->post(route('testimonials.store'), $data);

        $response->assertRedirect(route('testimonials.index'));
        $response->assertSessionHas('success');
    }

    public function test_order_form_returns_200(): void
    {
        $response = $this->get(route('order.create'));

        $response->assertOk();
    }

    public function test_order_form_validates_required_fields(): void
    {
        $response = $this->post(route('order.store'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'items']);
    }
}
