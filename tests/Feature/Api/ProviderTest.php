<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_can_list_providers()
	{
		ProviderProfile::factory()->count(3)->create(['status' => 'approved']);

		$response = $this->getJson('/api/v1/providers');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'data' => [
						'*' => ['id', 'display_name', 'city', 'avg_rating']
					]
				]
			]);
	}

	public function test_can_show_provider()
	{
		$provider = ProviderProfile::factory()->create(['status' => 'approved']);

		$response = $this->getJson("/api/v1/providers/{$provider->id}");

		$response->assertStatus(200)
			->assertJsonFragment(['display_name' => $provider->display_name]);
	}

	public function test_provider_can_manage_services()
	{
		$user = User::factory()->create();
		$user->assignRole('provider');
		$profile = ProviderProfile::factory()->create(['user_id' => $user->id, 'status' => 'approved']);

		$service = Service::factory()->create();

		// 1. Attach Service
		$response = $this->actingAs($user)
			->postJson('/api/v1/provider/services', [
				'service_id' => $service->id,
				'price_min' => 50,
				'price_max' => 100,
			]);

		$response->assertStatus(201);
		$this->assertDatabaseHas('provider_services', [
			'provider_id' => $profile->id,
			'service_id' => $service->id,
			'price_min' => 50,
		]);

		// 2. List Services
		$response = $this->actingAs($user)
			->getJson('/api/v1/provider/services');

		$response->assertStatus(200)
			->assertJsonCount(1, 'data');

		// 3. Update Service
		$response = $this->actingAs($user)
			->putJson("/api/v1/provider/services/{$service->id}", [
				'price_min' => 60,
				'price_max' => 120,
			]);

		$response->assertStatus(200);
		$this->assertDatabaseHas('provider_services', [
			'provider_id' => $profile->id,
			'service_id' => $service->id,
			'price_min' => 60,
		]);

		// 4. Detach Service
		$response = $this->actingAs($user)
			->deleteJson("/api/v1/provider/services/{$service->id}");

		$response->assertStatus(200);
		$this->assertDatabaseMissing('provider_services', [
			'provider_id' => $profile->id,
			'service_id' => $service->id,
		]);
	}
}
