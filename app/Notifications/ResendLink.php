<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\UserReservation;

class ResendLink extends Notification
{
    use Queueable;

    public  $user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserReservation $user)
    {
        $this->user = $user;
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
        $url = url("/check-in?id={$this->user->id}");

        return (new MailMessage)
            ->bcc('avenuemontaigneconcierge@gmail.com')
            ->subject('Check-In Confirmation')
            ->greeting('Hello '. Ucfirst(optional($this->user->guest_user)->name))
            ->line('Thank your for making a reservation with us. Before you can gain access to your apartment, you’re required to check-in and provide a copy of your ID. Please click the link below to complete your check-in process.')
            ->action('Check In', $url)
            ->line('Thank you for choosing our service!');
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
