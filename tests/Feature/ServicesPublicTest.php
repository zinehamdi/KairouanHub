<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_services_index_and_detail(): void
    {
        $service = Service::factory()->for(Category::factory())->create(['is_active' => true]);

        $this->get(route('services.index'))->assertOk();
        $this->get(route('services.show', $service->slug))->assertOk();
    }
}
