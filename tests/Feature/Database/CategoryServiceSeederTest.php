<?php

namespace Tests\Feature\Database;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceSeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_minimum_categories_and_services(): void
    {
        $this->seed();

        $this->assertGreaterThanOrEqual(5, Category::count(), 'Expected at least 5 categories');
        $this->assertGreaterThanOrEqual(15, Service::count(), 'Expected at least 15 services');

        Service::all()->each(function(Service $service){
            $this->assertNotNull($service->category, 'Service missing category relation');
            $this->assertTrue($service->is_active, 'Service expected to be active');
        });
    }
}
