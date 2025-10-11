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
            ->mailer('zeptomail') // 👈 Force this notification to use ZeptoMail
            ->greeting("Dear " . $this->guest->name . ',')
            ->subject("Welcome to Avenue Montaigne")
            ->line('Welcome to Avenue Montaigne,   We are thrilled to have you as our guest and hope your stay with us will be comfortable, enjoyable, and memorable.')
            ->line("As you settle into your home away from home, please don't hesitate to reach out to our friendly staff for any assistance you may need. We're here to ensure that your stay exceeds your expectations in every way possible.")
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
