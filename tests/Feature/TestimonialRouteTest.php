<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestimonialRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonial_page_returns_200(): void
    {
        $response = $this->get(route('testimonials.index'));

        $response->assertOk();
    }

    public function test_testimonial_page_shows_approved_testimonials(): void
    {
        $testimonial = Testimonial::factory()->create([
            'status' => 'approved',
            'name' => 'Budi Santoso',
        ]);

        $response = $this->get(route('testimonials.index'));

        $response->assertOk();
        $response->assertSee($testimonial->name);
        $response->assertSee($testimonial->content);
    }

    public function test_testimonial_page_does_not_show_pending(): void
    {
        $testimonial = Testimonial::factory()->create([
            'status' => 'pending',
            'name' => 'Pending User',
        ]);

        $response = $this->get(route('testimonials.index'));

        $response->assertOk();
        $response->assertDontSee($testimonial->name);
    }

    public function test_testimonial_page_does_not_show_rejected(): void
    {
        $testimonial = Testimonial::factory()->create([
            'status' => 'rejected',
            'name' => 'Rejected User',
        ]);

        $response = $this->get(route('testimonials.index'));

        $response->assertOk();
        $response->assertDontSee($testimonial->name);
    }

    public function test_testimonial_store_creates_pending_testimonial(): void
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'company' => 'Acme Corp',
            'content' => 'Great service!',
        ];

        $response = $this->post(route('testimonials.store'), $data);

        $response->assertRedirect(route('testimonials.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('testimonials', [
            'name' => 'Jane Doe',
            'status' => 'pending',
        ]);
    }

    public function test_testimonial_store_validates_required_fields(): void
    {
        $response = $this->post(route('testimonials.store'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'content']);
    }

    public function test_testimonial_store_validates_email_format(): void
    {
        $response = $this->post(route('testimonials.store'), [
            'name' => 'Test',
            'email' => 'not-an-email',
            'content' => 'Test content',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }
}
