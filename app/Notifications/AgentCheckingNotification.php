<?php

namespace App\Notifications;

use App\Models\Apartment;
use App\Models\Attribute;
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

    public $apartment;

    public $reservation;



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(GuestUser $guest, Apartment $apartment, Reservation $reservation)
    {

        $this->guest = $guest;

        $this->apartment = $apartment;

        $this->reservation = $reservation;
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
            ->subject('New check-in for ' . optional($this->apartment->attribute)->name)
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
