<?php

namespace App\Notifications;

use App\Models\ProviderSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProviderSubmissionProcessed extends Notification
{
    use Queueable;

    public function __construct(
        private ProviderSubmission $submission,
        private string $status, // 'approved' or 'rejected'
        private ?int $pointsEarned = 0,
        private ?int $trustScoreAdjusted = 0
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'provider_name' => $this->submission->provider_name,
            'status' => $this->status,
            'points_earned' => $this->pointsEarned,
            'trust_score_adjusted' => $this->trustScoreAdjusted,
            'message' => $this->status === 'approved' 
                ? "Excellent! Your suggestion for '{$this->submission->provider_name}' has been approved. You earned {$this->pointsEarned} points!"
                : "Your suggestion for '{$this->submission->provider_name}' was not accepted: {$this->submission->rejection_reason}",
        ];
    }
}
