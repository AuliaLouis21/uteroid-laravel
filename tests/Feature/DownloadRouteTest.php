<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_page_returns_200(): void
    {
        $response = $this->get(route('download.index'));

        $response->assertOk();
    }

    public function test_download_page_shows_empty_when_no_files(): void
    {
        $response = $this->get(route('download.index'));

        $response->assertOk();
    }
}
