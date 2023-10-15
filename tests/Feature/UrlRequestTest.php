<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_url_request(): void
    {
        $url = "https://www.foxnews.com/";
        $response = $this->post('/v1/url-crawler', ['url' => $url]);
        $response->assertStatus(200);

        $this->assertDatabaseHas("url_requests", [
            "url" => $url,
            "host" => parse_url($url)['host'],
            "path" => parse_url($url)['path'],
        ]);
    }
}