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
        $providerName = $this->submission->provider_name;
        
        if ($this->status === 'approved') {
            $message = $this->pointsEarned > 0
                ? "مبارك عليك! اقتراحك على {$providerName} تم قبوله. ربحت {$this->pointsEarned} نقطة."
                : "مبارك عليك! اقتراحك على {$providerName} تم قبوله.";
        } else {
            $reason = $this->submission->rejection_reason ?? '';
            if ($reason) {
                $message = "للأسف، اقتراحك على {$providerName} ما تمش. {$reason}";
            } else {
                $message = "للأسف، اقتراحك على {$providerName} ما تمش. ما تقلقش، في توصيات تانية تقدر توصي بيها.";
            }
        }

        return [
            'submission_id' => $this->submission->id,
            'provider_name' => $providerName,
            'status' => $this->status,
            'points_earned' => $this->pointsEarned,
            'trust_score_adjusted' => $this->trustScoreAdjusted,
            'message' => $message,
        ];
    }
}
