<?php

namespace App\Mail;

use Swift_Mime_SimpleMessage;
use Swift_Transport;
use Swift_Events_EventListener;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ZeptoMailTransport implements Swift_Transport
{
    protected $apikey;
    protected $host;
    protected $client;
    protected $started = true;

    public function __construct($apikey, $host)
    {
        $this->apikey = $apikey;
        $this->host = rtrim($host, '/');
        $this->client = new Client(['timeout' => 30]);
    }

    public function isStarted()
    {
        return $this->started;
    }

    public function start()
    {
        $this->started = true;
    }

    public function stop()
    {
        $this->started = false;
    }

    public function ping()
    {
        try {
            $response = $this->client->get('https://api.zeptomail.com/v1.0/email/template', [
                'headers' => [
                    'Authorization' => $this->apikey,
                    'Accept' => 'application/json',
                ],
            ]);
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::error('ZeptoMail ping failed: ' . $e->getMessage());
            return false;
        }
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $failedRecipients = (array) $failedRecipients;
        $payload = $this->buildPayload($message);

        

        try {
            $response = $this->client->post('https://api.zeptomail.com/v1.1/email', [
                'headers' => [
                    'Authorization' => 'Zoho-enczapikey ' . $this->apikey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $status = $response->getStatusCode();

            if ($status >= 200 && $status < 300) {
                return $this->countRecipients($message);
            }

            Log::error("ZeptoMail API returned status: {$status}");
            return 0;
        } catch (RequestException $e) {
            Log::error('ZeptoMail send failed: ' . $e->getMessage());
            return 0;
        }
    }

    protected function getEndpoint()
    {
        return $this->host . '/v1.1/email';
    }

    protected function countRecipients(Swift_Mime_SimpleMessage $message)
    {
        return count((array) $message->getTo())
            + count((array) $message->getCc())
            + count((array) $message->getBcc());
    }

    protected function buildPayload(Swift_Mime_SimpleMessage $email)
    {
        $from = $email->getFrom();
        $to = $email->getTo();
        $cc = $email->getCc();
        $bcc = $email->getBcc();

        $payload = [
            'from' => [
                'address' => key($from),
                'name' => reset($from),
            ],
            'to' => $this->formatAddresses($to),
            'cc' => $this->formatAddresses($cc),
            'bcc' => $this->formatAddresses($bcc),
            'subject' => $email->getSubject(),
            'htmlbody' => $email->getBody(),
        ];

        // ✅ Attachments (for SwiftMailer)
        $attachmentJSONArr = [];
        foreach ($email->getChildren() as $child) {
            if (method_exists($child, 'getContentType') && $child->getContentType() !== 'text/plain' && $child->getContentType() !== 'text/html') {
                $filename = $child->getFilename();
                $att = [
                    'content' => base64_encode($child->getBody()),
                    'name' => $filename ?: 'attachment',
                    'mime_type' => $child->getContentType(),
                ];
                $attachmentJSONArr[] = $att;
            }
        }

        if (!empty($attachmentJSONArr)) {
            $payload['attachments'] = $attachmentJSONArr;
        }

        return $payload;
    }

    protected function formatAddresses($contacts)
    {
        $formatted = [];

        if (is_array($contacts)) {
            foreach ($contacts as $email => $name) {
                $formatted[] = [
                    'email_address' => [
                        'address' => $email,
                        'name' => $name,
                    ]
                ];
            }
        }

        return $formatted;
    }

    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        // Not used
    }

    public function __toString()
    {
        return 'zeptomail';
    }
}
