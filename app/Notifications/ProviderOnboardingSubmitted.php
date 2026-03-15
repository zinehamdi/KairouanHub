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
            ->subject('تم تسجيلك في KairouanHub!')
            ->line('مرحبا بك في المجتمع!')
            ->line('ملفك الشخصي جاهز ورانا نتحققوا منه قريباً.')
            ->line('بعد الموافقة، فيك تبدأ تتلقى طلبات.')
            ->action('شوف ملفك', url(route('provider.dashboard')));
    }
}
