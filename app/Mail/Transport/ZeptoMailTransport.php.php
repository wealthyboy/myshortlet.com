<?php

namespace App\Mail\Transports;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
use Illuminate\Support\Facades\Http;

class ZeptoMailTransport extends Transport
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $to = collect($message->getTo())->map(function ($name, $email) {
            return ["email_address" => ["address" => $email, "name" => $name]];
        })->values()->all();

        $bcc = collect($message->getBcc())->map(function ($name, $email) {
            return ["email_address" => ["address" => $email, "name" => $name]];
        })->values()->all();

        $subject = $message->getSubject();
        $htmlBody = $message->getBody();

        Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => 'Zoho-encz ' . $this->token,
            'content-type' => 'application/json',
        ])->post('https://api.zeptomail.com/v1.1/email', [
            "from" => [
                "address" => config('mail.from.address'),
                "name" => config('mail.from.name'),
            ],
            "to" => $to,
            "bcc" => $bcc,
            "subject" => $subject,
            "htmlbody" => $htmlBody,
        ]);

        return $this->numberOfRecipients($message);
    }
}
