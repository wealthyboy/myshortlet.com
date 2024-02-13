<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGuest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            ->subject("Welcome to Avenue Montaigne")
            ->line('On behalf of the entire team at Avenue Montaigne, I would like to extend a warm welcome to you! We are thrilled to have you as our guest and hope your stay with us will be comfortable, enjoyable, and memorable.')
            ->line("Located in the heart of Lagos, Avenue Montaigne offers unparalleled comfort and convenience. Whether you're here for business or leisure, our spacious and elegantly appointed apartments provide the perfect retreat after a day of exploration or work.")
            ->line("As you settle into your home away from home, please don't hesitate to reach out to our friendly staff for any assistance you may need. We're here to ensure that your stay exceeds your expectations in every way possible.")
            ->line("We hope you have a fantastic time exploring the vibrant surroundings and experiencing all that Avenue Montaigne and [City/Neighborhood] have to offer.")
            ->line("As you settle into your home away from home, please don't hesitate to reach out to our friendly staff for any assistance you may need. We're here to ensure that your stay exceeds your expectations in every way possible.")
            ->line("Once again, welcome to Avenue Montaigne Serviced Apartments! We look forward to making your stay exceptional.")
            ->line("Warm regards,")
            ->line("Avenue Montaigne")

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
