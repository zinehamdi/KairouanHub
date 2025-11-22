<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends BaseApiController
{
	/**
	 * List my conversations.
	 */
	public function conversations(Request $request)
	{
		$userId = $request->user()->id;

		$conversations = Conversation::where('participant_one_id', $userId)
			->orWhere('participant_two_id', $userId)
			->with(['participantOne', 'participantTwo', 'jobRequest'])
			->withCount('messages')
			->orderBy('last_message_at', 'desc')
			->paginate(20);

		return $this->successResponse(
			ConversationResource::collection($conversations)->response()->getData(true)
		);
	}

	/**
	 * Get messages for a conversation.
	 */
	public function messages(Request $request, $conversationId)
	{
		$userId = $request->user()->id;

		$conversation = Conversation::where('id', $conversationId)
			->where(function ($q) use ($userId) {
				$q->where('participant_one_id', $userId)
					->orWhere('participant_two_id', $userId);
			})
			->firstOrFail();

		$messages = $conversation->messages()
			->with('sender')
			->orderBy('created_at', 'asc')
			->paginate(50);

		// Mark messages as read
		$conversation->messages()
			->where('sender_id', '!=', $userId)
			->whereNull('read_at')
			->update(['read_at' => now()]);

		return $this->successResponse(
			MessageResource::collection($messages)->response()->getData(true)
		);
	}

	/**
	 * Send a message.
	 */
	public function sendMessage(Request $request)
	{
		$request->validate([
			'recipient_id' => 'required|exists:users,id',
			'body' => 'required|string|max:1000',
			'job_request_id' => 'nullable|exists:job_requests,id',
		]);

		$userId = $request->user()->id;
		$recipientId = $request->recipient_id;

		// Ensure participant_one_id is always the smaller ID for consistency
		$participantOne = min($userId, $recipientId);
		$participantTwo = max($userId, $recipientId);

		// Find or create conversation
		$conversation = Conversation::firstOrCreate([
			'participant_one_id' => $participantOne,
			'participant_two_id' => $participantTwo,
			'job_request_id' => $request->job_request_id,
		]);

		// Create message
		$message = Message::create([
			'conversation_id' => $conversation->id,
			'sender_id' => $userId,
			'body' => $request->body,
		]);

		// Update conversation timestamp
		$conversation->update(['last_message_at' => now()]);

		// TODO: Broadcast event (Phase 7 - Real-time)
		// event(new MessageSent($message));

		return $this->successResponse(
			new MessageResource($message->load('sender')),
			'Message sent successfully.',
			201
		);
	}
}
