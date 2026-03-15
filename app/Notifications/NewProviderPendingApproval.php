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
        $name = $this->profile->display_name;
        
        return (new MailMessage)
            ->subject('مزود جديد محتاج مراجعة')
            ->line("{$name} سجل في KairouanHub وحابب ينضم للمجتمع.")
            ->line('راجع ملفه وقبل أو ارفض.')
            ->action('لوحة التحكم', url('/admin'));
    }
}
