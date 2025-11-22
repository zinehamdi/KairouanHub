<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$userId = $request->user()->id;
		$otherParticipant = $this->otherParticipant($userId);

		return [
			'id' => $this->id,
			'other_participant' => new UserResource($otherParticipant),
			'job_request' => new JobRequestResource($this->whenLoaded('jobRequest')),
			'last_message_at' => $this->last_message_at?->toIso8601String(),
			'last_message' => new MessageResource($this->whenLoaded('messages', function () {
				return $this->messages->last();
			})),
			'created_at' => $this->created_at->toIso8601String(),
		];
	}
}
