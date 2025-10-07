<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use ZeptoMail\ZeptoMailClient;

class ZeptoMailTransport extends Transport
{
    protected $client;

    public function __construct()
    {
        $this->client = new \ZeptoMail\ZeptoMailClient(env('ZEPTO_TOKEN'));
    }

   public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
{
    $this->beforeSendPerformed($message);

    $payload = [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME'),
        ],
        'subject' => $message->getSubject(),
        'htmlbody' => $message->getBody(),
    ];

    // To, CC, BCC
    foreach (['to', 'cc', 'bcc'] as $type) {
        if ($emails = $message->{'get' . ucfirst($type)}()) {
            $payload[$type] = collect($emails)->map(function ($name, $email) {
                return ['email_address' => ['address' => $email, 'name' => $name]];
            })->values()->toArray();
        }
    }

    // Reply-To
    if ($reply = $message->getReplyTo()) {
        $payload['reply_to'] = [
            'address' => key($reply),
            'name' => reset($reply),
        ];
    }

    // Attachments (robust detection)
    $attachments = [];
    foreach ($message->getChildren() as $child) {
        // Skip text/plain or text/html parts
        if (strpos($child->getContentType(), 'text/') === 0) {
            continue;
        }

        // Handle file attachments
        if ($child->getFilename()) {
            $attachments[] = [
                'name' => $child->getFilename(),
                'content' => base64_encode($child->getBody()),
                'mime_type' => $child->getContentType(),
            ];
        }
    }

    if (!empty($attachments)) {
        $payload['attachments'] = $attachments;
    }

    // Send mail via ZeptoMail API
    $this->client->sendMail($payload);

    $this->sendPerformed($message);
}

}
