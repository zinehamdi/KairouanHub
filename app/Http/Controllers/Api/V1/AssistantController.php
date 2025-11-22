<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class AssistantController extends BaseApiController
{
	protected $openai;

	public function __construct(OpenAIService $openai)
	{
		$this->openai = $openai;
	}

	/**
	 * Chat with AI assistant.
	 */
	public function chat(Request $request)
	{
		$request->validate([
			'message' => 'required|string|max:500',
			'context' => 'nullable|array',
		]);

		try {
			// Build message history
			$messages = [
				['role' => 'system', 'content' => $this->openai->getSystemPrompt()],
			];

			// Add context if provided
			if ($request->has('context') && is_array($request->context)) {
				foreach ($request->context as $msg) {
					if (isset($msg['role']) && isset($msg['content'])) {
						$messages[] = $msg;
					}
				}
			}

			// Add current user message
			$messages[] = ['role' => 'user', 'content' => $request->message];

			// Get AI response
			$response = $this->openai->chat($messages);

			return $this->successResponse([
				'message' => $response,
				'context' => array_merge($messages, [
					['role' => 'assistant', 'content' => $response]
				]),
			]);

		} catch (\Exception $e) {
			return $this->errorResponse(
				'Failed to get AI response: ' . $e->getMessage(),
				500
			);
		}
	}
}
