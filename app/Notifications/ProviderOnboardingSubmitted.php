<?php

namespace App\Notifications;

use App\Models\ProviderProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProviderOnboardingSubmitted extends Notification
{
    use Queueable;

    public function __construct(public ProviderProfile $profile) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Provider Onboarding Submitted')
            ->line('Your provider profile has been submitted and is pending review.')
            ->action('View Dashboard', url(route('provider.dashboard')));
    }
}
