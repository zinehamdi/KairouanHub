<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Test the health endpoint which doesn't require database data
        $response = $this->get('/healthz');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'ok']);
    }
}

