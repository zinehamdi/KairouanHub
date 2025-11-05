<?php

namespace Tests\Feature\Providers;

use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MigrationsAndFactoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_runs_migrations_and_creates_provider_profile_with_services(): void
    {
        $user = User::factory()->create();
        $profile = ProviderProfile::factory()->approved()->create(['user_id' => $user->id]);
        $services = Service::factory()->count(2)->create();
        $profile->services()->attach([
            $services[0]->id => ['price_min' => 50, 'price_max' => 100],
            $services[1]->id => ['price_min' => 70, 'price_max' => 150],
        ]);

        $this->assertEquals(2, $profile->services()->count());
    }

    public function test_enforces_unique_provider_service_pivot(): void
    {
        $profile = ProviderProfile::factory()->approved()->create();
        $service = Service::factory()->create();
        $profile->services()->attach([$service->id => ['price_min' => 10, 'price_max' => 20]]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $profile->services()->attach([$service->id => ['price_min' => 15, 'price_max' => 25]]);
    }
}
