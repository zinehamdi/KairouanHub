<?php

namespace Tests\Feature\Api;

use App\Models\DeliveryMission;
use App\Models\DriverProfile;
use App\Models\JobRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriverTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_driver_can_manage_profile()
	{
		$user = User::factory()->create();
		$user->assignRole('driver');

		// 1. Get Profile (Auto-create)
		$response = $this->actingAs($user)
			->getJson('/api/v1/driver/profile');

		$response->assertStatus(200)
			->assertJsonFragment(['vehicle_type' => 'car']);

		// 2. Update Profile
		$response = $this->actingAs($user)
			->putJson('/api/v1/driver/profile', [
				'vehicle_type' => 'bike',
				'license_plate' => '123-TN-456',
			]);

		$response->assertStatus(200)
			->assertJsonFragment(['vehicle_type' => 'bike']);
	}

	public function test_driver_can_update_status_and_location()
	{
		$user = User::factory()->create();
		$user->assignRole('driver');
		$profile = DriverProfile::create(['user_id' => $user->id]);

		// Toggle Status
		$this->actingAs($user)
			->putJson('/api/v1/driver/status', ['is_online' => true])
			->assertStatus(200);

		$this->assertTrue($profile->fresh()->is_online);

		// Update Location
		$this->actingAs($user)
			->putJson('/api/v1/driver/location', ['lat' => 35.678, 'lng' => 10.100])
			->assertStatus(200);

		$this->assertEquals(35.678, $profile->fresh()->current_lat);
	}

	public function test_driver_can_accept_mission()
	{
		$driverUser = User::factory()->create();
		$driverUser->assignRole('driver');
		DriverProfile::create(['user_id' => $driverUser->id, 'is_online' => true]);

		$jobRequest = JobRequest::factory()->create();
		$mission = DeliveryMission::create(['job_request_id' => $jobRequest->id, 'status' => 'pending']);

		// 1. List Available
		$this->actingAs($driverUser)
			->getJson('/api/v1/driver/missions/available')
			->assertStatus(200)
			->assertJsonCount(1, 'data.data');

		// 2. Accept
		$this->actingAs($driverUser)
			->postJson("/api/v1/driver/missions/{$mission->id}/accept")
			->assertStatus(200);

		$this->assertEquals('accepted', $mission->fresh()->status);
		$this->assertEquals($driverUser->driverProfile->id, $mission->fresh()->driver_id);
	}
}
