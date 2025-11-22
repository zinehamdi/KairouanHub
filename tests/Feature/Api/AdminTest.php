<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_admin_can_assign_role()
	{
		$admin = User::factory()->create();
		$admin->assignRole('admin');

		$user = User::factory()->create();

		$response = $this->actingAs($admin)
			->postJson("/api/v1/admin/users/{$user->id}/assign-role", [
				'role' => 'driver',
			]);

		$response->assertStatus(200)
			->assertJson(['message' => "Role 'driver' assigned successfully."]);

		$this->assertTrue($user->refresh()->hasRole('driver'));
	}

	public function test_non_admin_cannot_assign_role()
	{
		$user = User::factory()->create();
		$targetUser = User::factory()->create();

		$response = $this->actingAs($user)
			->postJson("/api/v1/admin/users/{$targetUser->id}/assign-role", [
				'role' => 'driver',
			]);

		$response->assertStatus(403);
	}

	public function test_admin_can_approve_provider()
	{
		$admin = User::factory()->create();
		$admin->assignRole('admin');

		$providerUser = User::factory()->create();
		ProviderProfile::factory()->create([
			'user_id' => $providerUser->id,
			'status' => 'pending',
		]);

		$response = $this->actingAs($admin)
			->postJson("/api/v1/admin/providers/{$providerUser->id}/approve");

		$response->assertStatus(200)
			->assertJson(['message' => 'Provider approved successfully.']);

		$this->assertEquals('approved', $providerUser->providerProfile->fresh()->status);
		$this->assertTrue($providerUser->refresh()->hasRole('provider'));
	}
}
