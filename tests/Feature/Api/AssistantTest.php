<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\OpenAIService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AssistantTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);

		// Mock OpenAI Service to avoid API key requirement
		$mockOpenAI = Mockery::mock(OpenAIService::class);
		$mockOpenAI->shouldReceive('getSystemPrompt')
			->andReturn('You are a helpful assistant.');
		$mockOpenAI->shouldReceive('chat')
			->andReturn('Hello! How can I help you today?');

		$this->app->instance(OpenAIService::class, $mockOpenAI);
	}

	public function test_can_chat_with_assistant()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)
			->postJson('/api/v1/assistant/chat', [
				'message' => 'Hello',
			]);

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'message',
					'context',
				],
			]);
	}

	public function test_requires_authentication()
	{
		$response = $this->postJson('/api/v1/assistant/chat', [
			'message' => 'Hello',
		]);

		$response->assertStatus(401);
	}

	public function test_validates_message()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)
			->postJson('/api/v1/assistant/chat', []);

		$response->assertStatus(422)
			->assertJsonValidationErrors(['message']);
	}
}
