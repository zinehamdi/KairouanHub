<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** EN: Notifies client of a new offer. AR: إشعار العميل بعرض جديد */
class NewOfferNotification extends Notification
{
    use Queueable;

    public function __construct(public Offer $offer) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New offer on your request')
            ->line('A provider submitted a new offer.')
            ->action('View Request', route('requests.show', $this->offer->request_id));
    }
}
