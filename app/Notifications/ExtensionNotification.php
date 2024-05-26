<?php

namespace App\Notifications;

use App\Models\Apartment;
use App\Models\GuestUser;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExtensionNotification extends Notification
{
    use Queueable;


    public $reservation;

    public $guest;

    public $apartment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation, GuestUser $user, Apartment $apartment)
    {
        $this->reservation = $reservation;
        $this->guest = $user;
        $this->apartment = $apartment;
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
            ->subject('Extension for ' . optional($this->apartment->attribute)->name)
            ->greeting('Hello Host,')
            ->line('Fullname: ' . $this->guest->name . ' ' . $this->guest->last_name)
            ->line('Check-in: ' . $this->reservation->checkin->format('l') . ' ' . $this->reservation->checkin->format('d') . ' ' . $this->reservation->checkin->format('F')  . ' ' . $this->reservation->checkin->isoFormat('Y'))
            ->line('Check-out: ' . $this->reservation->checkout->format('l') . ' ' . $this->reservation->checkout->format('d') . ' ' . $this->reservation->checkout->format('F')  . ' ' . $this->reservation->checkout->isoFormat('Y'));
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
