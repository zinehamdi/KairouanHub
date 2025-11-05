<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /** @test */
    public function health_route_returns_ok(): void
    {
        $this->get('/healthz')
            ->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
