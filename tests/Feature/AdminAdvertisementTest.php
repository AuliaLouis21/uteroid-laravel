<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAdvertisementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
    }

    protected function createAdvertisement(array $overrides = []): Advertisement
    {
        return Advertisement::create(array_merge([
            'title' => 'Test Advertisement',
            'slug' => 'test-advertisement',
            'content' => 'This is a test advertisement content.',
            'image' => null,
            'link' => 'https://example.com',
            'is_active' => true,
        ], $overrides));
    }

    public function test_admin_advertisement_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.advertisements.index'));

        $response->assertOk();
    }

    public function test_admin_advertisement_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.advertisements.create'));

        $response->assertOk();
    }

    public function test_admin_advertisement_store_creates_advertisement(): void
    {
        $data = [
            'title' => 'New Advertisement',
            'slug' => 'new-advertisement',
            'content' => 'New advertisement content.',
            'link' => 'https://example.com/new',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.advertisements.store'), $data);

        $response->assertRedirect(route('admin.advertisements.index'));
        $this->assertDatabaseHas('advertisements', ['title' => 'New Advertisement']);
    }

    public function test_admin_advertisement_show_returns_200(): void
    {
        $advertisement = $this->createAdvertisement();

        $response = $this->actingAs($this->user)->get(route('admin.advertisements.show', $advertisement));

        $response->assertOk();
    }

    public function test_admin_advertisement_edit_returns_200(): void
    {
        $advertisement = $this->createAdvertisement();

        $response = $this->actingAs($this->user)->get(route('admin.advertisements.edit', $advertisement));

        $response->assertOk();
    }

    public function test_admin_advertisement_update_updates_advertisement(): void
    {
        $advertisement = $this->createAdvertisement(['title' => 'Old Title']);

        $data = [
            'title' => 'Updated Advertisement Title',
            'slug' => $advertisement->slug,
            'content' => $advertisement->content,
            'link' => $advertisement->link,
            'is_active' => $advertisement->is_active,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.advertisements.update', $advertisement), $data);

        $response->assertRedirect(route('admin.advertisements.index'));
        $this->assertDatabaseHas('advertisements', ['id' => $advertisement->id, 'title' => 'Updated Advertisement Title']);
    }

    public function test_admin_advertisement_destroy_deletes_advertisement(): void
    {
        $advertisement = $this->createAdvertisement();

        $response = $this->actingAs($this->user)->delete(route('admin.advertisements.destroy', $advertisement));

        $response->assertRedirect(route('admin.advertisements.index'));
        $this->assertDatabaseMissing('advertisements', ['id' => $advertisement->id]);
    }
}
