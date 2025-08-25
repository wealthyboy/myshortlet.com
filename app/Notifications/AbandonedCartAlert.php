<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartAlert extends Notification
{
    use Queueable;

    public $track;

    public function __construct($track)
    {
        $this->track = $track;
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
            ->subject('Abandoned Booking Notification')
            ->greeting('Hi Admin,')
            ->line('A user has abandoned their booking. Here are the details:')
            ->line('Full Name: ' . ($this->track->first_name ?? 'N/A') . ' ' . ($this->track->last_name ?? ''))
            ->line('Check-in: ' . ($this->track->from ?? 'N/A'))
            ->line('Check-out: ' . ($this->track->to ?? 'N/A'))
            ->line('Email: ' . ($this->track->email ?? 'N/A'))
            ->line('Phone Number: ' . ($this->track->phone_number ?? 'N/A'))
            ->line('Source: ' . ($this->track->referrer ?? 'Unknown'))
            ->line('Apartment Name: ' . (optional($this->track->apartment)->name ?? 'N/A'))
            ->line('Ip Address: ' . ($this->track->ip_address ?? 'N/A'))
            ->line('Amount: $' . number_format(optional($this->track->apartment)->price ?? 0, 2))
            ->line('Country: ', $this->track->country ?? '#')

            ->action('Visit Website', url('/'))
            ->line('You are receiving this because the user did not complete their booking.');
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
