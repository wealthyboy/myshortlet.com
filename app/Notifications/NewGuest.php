<?php

namespace App\Notifications;

use App\Models\GuestUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGuest extends Notification
{
    use Queueable;

    public $guest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(GuestUser $guestUser)
    {
        $this->guest = $guestUser;
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
            ->greeting("Dear " . $this->guest->name, ',')
            ->subject("Welcome to Avenue Montaigne")
            ->line('On behalf of the entire team at Avenue Montaigne, I would like to extend a warm welcome to you! We are thrilled to have you as our guest and hope your stay with us will be comfortable, enjoyable, and memorable.')
            ->line("Warm regards,")
            ->line("Avenue Montaigne.")
            ->action('Visit our website', url('https://avenuemontaigne.ng'))
            ->line('Thank you for using our application!');
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
