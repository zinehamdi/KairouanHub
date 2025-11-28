<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
	protected $client;

	public function __construct()
	{
		$apiKey = config('services.openai.api_key');

		if ($apiKey) {
			$this->client = OpenAI::client($apiKey);
		}
	}

	/**
	 * Send a chat message to OpenAI.
	 *
	 * @param array $messages Array of message objects with 'role' and 'content'
	 * @param string $model Model to use (default: gpt-4o-mini)
	 * @return string
	 */
	public function chat(array $messages, string $model = 'gpt-4o-mini'): string
	{
		$response = $this->client->chat()->create([
			'model' => $model,
			'messages' => $messages,
			'max_tokens' => 500,
		]);

		return $response->choices[0]->message->content;
	}

	/**
	 * Generate a system prompt for the KairouanHub assistant.
	 */
	public function getSystemPrompt(): string
	{
		return "You are a helpful assistant for KairouanHub, a platform connecting users with service providers in Kairouan, Tunisia. "
			. "You help users find services, understand how the platform works, and answer general questions. "
			. "Be concise, friendly, and professional. If asked about specific providers or services, "
			. "suggest the user browse the platform's listings.";
	}
}
