<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ChatMessage;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_endpoint_returns_reply_and_persists()
    {
        $response = $this->postJson(route('chatbot.message'), [
            'content' => 'Hello there',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['reply']);

        $this->assertDatabaseCount('chat_messages', 2);

        $this->assertDatabaseHas('chat_messages', [
            'role' => 'user',
            'content' => 'Hello there',
        ]);
        $this->assertDatabaseHas('chat_messages', [
            'role' => 'assistant',
        ]);
    }

    public function test_history_endpoint_returns_messages()
    {
        // Seed by calling the message endpoint so session matches
        $this->postJson(route('chatbot.message'), ['content' => 'Hi']);

        $response = $this->getJson(route('chatbot.history', ['all' => 1]));

        $response->assertOk()
            ->assertJsonStructure(['messages']);

        $data = $response->json();
        $this->assertGreaterThanOrEqual(2, count($data['messages'] ?? []));
    }

    public function test_message_endpoint_without_api_key_uses_local_fallback()
    {
        // Ensure OPENAI_API_KEY not set
        putenv('OPENAI_API_KEY=');
        config(['openai.api_key' => null]);

        $response = $this->postJson(route('chatbot.message'), [
            'content' => 'Test local',
        ]);

        $response->assertOk();
        $reply = $response->json('reply');
        $this->assertIsString($reply);
        $this->assertStringContainsString('Local assistant response', $reply);
    }
}
