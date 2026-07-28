<?php

namespace Tests\Feature\Api;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonials_index_returns_approved_only(): void
    {
        Testimonial::factory()->count(3)->create(['status' => 'approved']);
        Testimonial::factory()->count(2)->create(['status' => 'pending']);
        Testimonial::factory()->count(1)->create(['status' => 'rejected']);

        $response = $this->getJson('/api/v1/testimonials');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_testimonial_store_creates_pending_testimonial(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company' => 'Acme Corp',
            'content' => 'Great service!',
            'rating' => 5,
        ];

        $response = $this->postJson('/api/v1/testimonials', $data);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'status'],
            ]);

        $this->assertDatabaseHas('testimonials', [
            'email' => 'john@example.com',
            'status' => 'pending',
        ]);
    }

    public function test_testimonial_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/testimonials', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'content', 'rating']);
    }

    public function test_testimonial_store_validates_rating_range(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'content' => 'Great service!',
            'rating' => 6,
        ];

        $response = $this->postJson('/api/v1/testimonials', $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['rating']);
    }
}
