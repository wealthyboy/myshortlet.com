<?php

namespace App\Notifications;

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AbandonedBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $track;

    public function __construct($track)
    {
        $this->track = $track;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hey ' . ($this->track->first_name ?? 'there') . ',')
            ->line('Looks like you didn’t finish your booking.')
            ->action('Complete your booking', $this->track->page_url)
            ->line('We saved your details — come back and complete it anytime.');
    }
}
