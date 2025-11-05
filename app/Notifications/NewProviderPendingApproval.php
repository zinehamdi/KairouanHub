<?php

namespace App\Notifications;

use App\Models\ProviderProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProviderPendingApproval extends Notification
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
            ->subject('New Provider Profile Pending Approval')
            ->line('A new provider profile requires review: '.$this->profile->display_name)
            ->action('Admin Panel', url('/admin'));
    }
}
