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
        $city = $this->request->city ?? 'مدينتك';
        
        return (new MailMessage)
            ->subject('في طلب خدمة جديد')
            ->line("في شخص في {$city} محتاج خدمتك.")
            ->line('شوف التفاصيل وابعثلو عرض.')
            ->action('شوف الطلب', route('requests.show', $this->request->id));
    }
}
