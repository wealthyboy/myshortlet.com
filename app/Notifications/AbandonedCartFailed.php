<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AbandonedCartFailed extends Notification
{
    use Queueable;

    public $exception;
    public $cart;

    public function __construct($exception, $cart = null)
    {
        $this->exception = $exception;
        $this->cart = $cart;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('❌ Abandoned Cart Job Failed')
            ->line('An error occurred in the abandoned cart job.')
            ->line('**Error:** ' . $this->exception->getMessage())
            ->line('**File:** ' . $this->exception->getFile())
            ->line('**Line:** ' . $this->exception->getLine())
            ->line('**Cart ID:** ' . optional($this->cart)->id)
            ->line('Please investigate.');
    }
}
