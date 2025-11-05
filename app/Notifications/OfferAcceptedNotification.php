<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** EN: Notifies provider their offer was accepted. AR: إشعار المزود بقبول عرضه */
class OfferAcceptedNotification extends Notification
{
    use Queueable;

    public function __construct(public Offer $offer) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your offer was accepted')
            ->line('Congratulations! Your offer has been accepted.')
            ->action('View Request', route('requests.show', $this->offer->request_id));
    }
}
