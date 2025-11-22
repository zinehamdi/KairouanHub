<?php

namespace Tests\Feature\Api;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_can_send_message()
	{
		$user1 = User::factory()->create();
		$user2 = User::factory()->create();

		$response = $this->actingAs($user1)
			->postJson('/api/v1/chat/messages', [
				'recipient_id' => $user2->id,
				'body' => 'Hello, how are you?',
			]);

		$response->assertStatus(201)
			->assertJsonFragment(['body' => 'Hello, how are you?']);

		$this->assertDatabaseHas('conversations', [
			'participant_one_id' => min($user1->id, $user2->id),
			'participant_two_id' => max($user1->id, $user2->id),
		]);

		$this->assertDatabaseHas('messages', [
			'sender_id' => $user1->id,
			'body' => 'Hello, how are you?',
		]);
	}

	public function test_can_list_conversations()
	{
		$user1 = User::factory()->create();
		$user2 = User::factory()->create();
		$user3 = User::factory()->create();

		// Create conversations
		$conv1 = Conversation::create([
			'participant_one_id' => min($user1->id, $user2->id),
			'participant_two_id' => max($user1->id, $user2->id),
			'last_message_at' => now(),
		]);

		$conv2 = Conversation::create([
			'participant_one_id' => min($user1->id, $user3->id),
			'participant_two_id' => max($user1->id, $user3->id),
			'last_message_at' => now()->subHour(),
		]);

		$response = $this->actingAs($user1)
			->getJson('/api/v1/chat/conversations');

		$response->assertStatus(200)
			->assertJsonCount(2, 'data.data');
	}

	public function test_can_get_messages()
	{
		$user1 = User::factory()->create();
		$user2 = User::factory()->create();

		$conversation = Conversation::create([
			'participant_one_id' => min($user1->id, $user2->id),
			'participant_two_id' => max($user1->id, $user2->id),
			'last_message_at' => now(),
		]);

		Message::create([
			'conversation_id' => $conversation->id,
			'sender_id' => $user1->id,
			'body' => 'First message',
		]);

		Message::create([
			'conversation_id' => $conversation->id,
			'sender_id' => $user2->id,
			'body' => 'Second message',
		]);

		$response = $this->actingAs($user1)
			->getJson("/api/v1/chat/conversations/{$conversation->id}/messages");

		$response->assertStatus(200)
			->assertJsonCount(2, 'data.data');
	}
}
