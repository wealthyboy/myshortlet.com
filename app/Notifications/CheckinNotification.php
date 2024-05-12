<?php

namespace App\Notifications;

use App\Models\GuestUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckinNotification extends Notification
{
    use Queueable;

    public  $guest;

    public  $apartment_owner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(GuestUser $guest, $apartment_owner = null)
    {
        $this->guest = $guest;

        $this->apartment_owner = $apartment_owner;
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
        $m = (new MailMessage)
            ->bcc('frontdesk@avenuemontaigne.ng');
        if ($this->apartment_owner) {
            $m->bcc($this->apartment_owner);
        }

        $m->subject('New check-in for ' . $this->guest->apartment_name)

            ->greeting('Hello!')
            ->line('You have a reservation');
        $m->attach(
            public_path('pdf/guest_' . $this->guest->name . '_' . $this->guest->id . '.pdf')
        );


        $m->line('Thank you for using our application!');

        return $m;
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
