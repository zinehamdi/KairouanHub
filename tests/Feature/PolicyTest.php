<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    /** @test */
    public function guests_cannot_access_protected_resources(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
