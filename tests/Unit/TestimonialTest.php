<?php

namespace Tests\Unit;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonial_has_correct_fillable_fields(): void
    {
        $testimonial = new Testimonial();

        $this->assertEquals([
            'name',
            'email',
            'company',
            'content',
            'rating',
            'status',
        ], $testimonial->getFillable());
    }

    public function test_testimonial_rating_is_cast_to_integer(): void
    {
        $testimonial = Testimonial::factory()->create(['rating' => '5']);

        $this->assertIsInt($testimonial->rating);
        $this->assertEquals(5, $testimonial->rating);
    }

    public function test_testimonial_can_be_created(): void
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'content' => 'Excellent service!',
            'status' => 'approved',
            'rating' => 5,
        ]);

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => 'Test User',
            'status' => 'approved',
        ]);
    }
}
