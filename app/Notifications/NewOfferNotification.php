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
            ->subject('في عرض جديد على طلبك!')
            ->line('مزود خدمة بعثلك عرض جديد.')
            ->line('شوف التفاصيل وتواصل معاه.')
            ->action('شوف الطلب', route('requests.show', $this->offer->request_id));
    }
}
