<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $user_reservation;

    public $settings;

    public function __construct($user_reservation,$settings)
    {
        $this->user_reservation = $user_reservation;
        
        $this->settings = $settings;
    }

    
    public function build()
    {   
        return $this->subject('AvenueMontaigne Confirmation')->view('emails.receipt.index');
    }
}
