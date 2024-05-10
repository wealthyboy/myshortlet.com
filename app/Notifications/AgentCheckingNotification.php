<?php

namespace App\Notifications;

use App\Models\GuestUser;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentCheckingNotification extends Notification
{
    use Queueable;

    public $guest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(GuestUser $guest)
    {

        $this->guest = $guest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New check-in for ' . $this->guest->apartment_name)
            ->greeting('Hello Host',)
            ->line('Fullname: ' . $this->guest->name . ' ' . $this->guest->last_name)
            ->line('Check-in: ' . $this->guest->checkin)
            ->line('Check-out: ' . $this->guest->checkout);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
