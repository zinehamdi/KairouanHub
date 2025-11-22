<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobRequestTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_user_can_create_request()
	{
		$user = User::factory()->create();
		$category = Category::factory()->create();
		$service = Service::factory()->create(['category_id' => $category->id]);
		$providerUser = User::factory()->create();
		$providerUser->assignRole('provider');
		$provider = ProviderProfile::factory()->create(['user_id' => $providerUser->id, 'status' => 'approved']);
		$provider->services()->attach($service->id);

		$response = $this->actingAs($user)
			->postJson('/api/v1/requests', [
				'category_id' => $category->id,
				'service_id' => $service->id,
				'provider_id' => $provider->id,
				'details' => 'I need help with my sink.',
				'city' => 'Kairouan',
				'scheduled_date' => now()->addDay()->toDateTimeString(),
			]);

		$response->assertStatus(201);
		$this->assertDatabaseHas('job_requests', [
			'client_id' => $user->id,
			'provider_id' => $provider->id,
			'status' => 'open',
		]);
	}

	public function test_provider_can_accept_request()
	{
		$providerUser = User::factory()->create();
		$providerUser->assignRole('provider');
		$provider = ProviderProfile::factory()->create(['user_id' => $providerUser->id, 'status' => 'approved']);

		$jobRequest = JobRequest::factory()->create([
			'provider_id' => $provider->id,
			'status' => 'open',
		]);

		$response = $this->actingAs($providerUser)
			->putJson("/api/v1/provider/requests/{$jobRequest->id}/status", [
				'status' => 'matched', // Accepted
			]);

		$response->assertStatus(200);
		$this->assertEquals('matched', $jobRequest->fresh()->status);
	}

	public function test_user_can_cancel_request()
	{
		$user = User::factory()->create();
		$jobRequest = JobRequest::factory()->create([
			'client_id' => $user->id,
			'status' => 'open',
		]);

		$response = $this->actingAs($user)
			->putJson("/api/v1/requests/{$jobRequest->id}/cancel");

		$response->assertStatus(200);
		$this->assertEquals('cancelled', $jobRequest->fresh()->status);
	}

	public function test_provider_cannot_accept_cancelled_request()
	{
		$providerUser = User::factory()->create();
		$providerUser->assignRole('provider');
		$provider = ProviderProfile::factory()->create(['user_id' => $providerUser->id]);

		$jobRequest = JobRequest::factory()->create([
			'provider_id' => $provider->id,
			'status' => 'cancelled',
		]);

		$response = $this->actingAs($providerUser)
			->putJson("/api/v1/provider/requests/{$jobRequest->id}/status", [
				'status' => 'matched',
			]);

		$response->assertStatus(400);
	}
}
