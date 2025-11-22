<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_register()
	{
		$response = $this->postJson('/api/v1/register', [
			'name' => 'Test User',
			'email' => 'test@example.com',
			'password' => 'password',
			'password_confirmation' => 'password',
		]);

		$response->assertStatus(201)
			->assertJsonStructure([
				'status',
				'message',
				'data' => [
					'user' => ['id', 'name', 'email'],
					'token',
				],
			]);

		$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
	}

	public function test_user_can_login()
	{
		$user = User::factory()->create([
			'email' => 'test@example.com',
			'password' => bcrypt('password'),
		]);

		$response = $this->postJson('/api/v1/login', [
			'email' => 'test@example.com',
			'password' => 'password',
		]);

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'message',
				'data' => [
					'token',
				],
			]);
	}

	public function test_user_can_get_profile()
	{
		$user = User::factory()->create();
		$token = $user->createToken('test-token')->plainTextToken;

		$response = $this->withHeaders([
			'Authorization' => 'Bearer ' . $token,
		])->getJson('/api/v1/me');

		$response->assertStatus(200)
			->assertJson([
				'data' => [
					'id' => $user->id,
					'email' => $user->email,
				],
			]);
	}

	public function test_user_can_logout()
	{
		$user = User::factory()->create();
		$token = $user->createToken('test-token')->plainTextToken;

		$response = $this->withHeaders([
			'Authorization' => 'Bearer ' . $token,
		])->postJson('/api/v1/logout');

		$response->assertStatus(200)
			->assertJson(['message' => 'Logged out successfully']);

		$this->assertCount(0, $user->tokens);
	}
}
