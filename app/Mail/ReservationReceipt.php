<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;



class ReservationReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $user_reservation;

    public $settings;

    public function __construct($user_reservation, $settings)
    {
        $this->user_reservation = $user_reservation;

        $this->settings = $settings;
    }


    public function build()
    {
        // if ($this->user_reservation->agent === 1) {
        //     return $this->subject('Reservation Confirmation For ' . optional($this->user_reservation)->apname)->view('emails.receipt.agent_receipt');
        // }

       $html = \View::make('emails.receipt.index', [
            'user_reservation' => $this->user_reservation,
            'settings' => $this->settings
        ])->render();

        // Send via ZeptoMail API
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => 'Zoho-encz ' . config('zeptomail.token'),
            'content-type' => 'application/json',
        ])->post('https://api.zeptomail.com/v1.1/email', [
            "from" => [
                "address" => "info@avenuemontaigne.ng",
                "name" => "Avenue Montaigne"
            ],
            "to" => [
                [
                    "email_address" => [
                        "address" => 'jacob.atam@gmail.com',
                        "name" => 'Jacob'
                    ]
                ]
            ],
            // "bcc" => [
            //     [
            //         "email_address" => [
            //             "address" => "bccperson@example.com",
            //             "name" => "Hidden Recipient"
            //         ]
            //     ]
            // ],
            "subject" => "Your Reservation Confirmation",
            "htmlbody" => $html,
        ]);


        return $this->from('info@avenuemontaigne.ng')
               ->subject('Reservation Confirmation: Your Stay at Avenue Montaigne')->view('emails.receipt.index');
    }
}
