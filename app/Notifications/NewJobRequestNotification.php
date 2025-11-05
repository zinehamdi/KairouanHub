<?php

namespace App\Notifications;

use App\Models\JobRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** EN: Notifies providers of a new job request. AR: إشعار المزودين بطلب خدمة جديد */
class NewJobRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public JobRequest $request) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New job request available')
            ->line('A new job request was posted in your category/city.')
            ->action('View Request', route('requests.show', $this->request->id));
    }
}
