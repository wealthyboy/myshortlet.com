<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserReservation;

class OtaReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public UserReservation $reservation
    ) {}

    public function build()
    {
        return $this
            ->subject('Your reservation is confirmed')
            ->view('emails.ota-confirmation');
    }
}
