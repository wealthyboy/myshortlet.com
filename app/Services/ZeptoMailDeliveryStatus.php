<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use RuntimeException;

class ZeptoMailDeliveryStatus
{
    protected $client;
    protected $logsUrl;
    protected $staticOauthToken;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 20,
            'connect_timeout' => 10,
        ]);

        $this->logsUrl = rtrim(
            config('zeptomail.logs_url', 'https://cpaas.zoho.com/v1.1/email'),
            '/'
        );

        $this->staticOauthToken = trim((string) config('zeptomail.logs_oauth_token'));
        $this->apiKey = trim((string) config('mail.mailers.zeptomail.key'));
    }

    /**
     * Look up the customer-recipient status for one invoice email.
     *
     * ZeptoMail's email-log API supports filtering by client_reference and
     * recipient, which keeps CC delivery states from affecting the customer's
     * invoice delivery state.
     */
    public function findByClientReference($clientReference, $recipient)
    {
        $authorizations = $this->authorizationCandidates();

        if (empty($authorizations)) {
            throw new RuntimeException(
                'ZeptoMail delivery tracking is not configured. Add a ZeptoMail email-log OAuth token or OAuth refresh credentials.'
            );
        }

        $lastUnauthorized = false;

        foreach ($authorizations as $authorization) {
            $response = $this->client->get($this->logsUrl, [
                'headers' => [
                    'Authorization' => $authorization,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'client_reference' => $clientReference,
                    'recipient' => $recipient,
                    'limit' => 10,
                ],
                'http_errors' => false,
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);

            if ($statusCode === 401 || $statusCode === 403) {
                $lastUnauthorized = true;
                continue;
            }

            if ($statusCode < 200 || $statusCode >= 300) {
                $message = data_get($body, 'error.message', 'ZeptoMail email-log request failed.');
                throw new RuntimeException($message . ' HTTP ' . $statusCode);
            }

            $logs = collect(data_get($body, 'data', []));

            if ($logs->isEmpty()) {
                return null;
            }

            $recipientLower = strtolower(trim((string) $recipient));

            $log = $logs->first(function ($item) use ($recipientLower) {
                return strtolower(trim((string) data_get($item, 'to'))) === $recipientLower;
            }) ?: $logs->first();

            return [
                'status' => strtolower(trim((string) data_get($log, 'status'))),
                'request_id' => data_get($log, 'request_id'),
                'email_reference' => data_get($log, 'email_reference'),
                'sent_time' => data_get($log, 'sent_time'),
            ];
        }

        if ($lastUnauthorized) {
            throw new RuntimeException(
                'ZeptoMail delivery tracking authorization failed. Use an OAuth token with Zeptomail.email.READ or Zeptomail.email.ALL scope.'
            );
        }

        return null;
    }

    protected function authorizationCandidates()
    {
        $authorizations = [];
        $oauthToken = $this->resolveOauthToken();

        if ($oauthToken !== '') {
            $authorizations[] = Str::startsWith($oauthToken, 'Zoho-oauthtoken ')
                ? $oauthToken
                : 'Zoho-oauthtoken ' . $oauthToken;
        }

        // Current ZeptoMail docs require OAuth for email logs. This API-key
        // fallback costs nothing and keeps compatibility with accounts where
        // the log endpoint also accepts the Agent API key.
        if ($this->apiKey !== '') {
            $authorizations[] = Str::startsWith($this->apiKey, 'Zoho-enczapikey ')
                ? $this->apiKey
                : 'Zoho-enczapikey ' . $this->apiKey;
        }

        return array_values(array_unique($authorizations));
    }

    protected function resolveOauthToken()
    {
        $clientId = trim((string) config('zeptomail.oauth_client_id'));
        $clientSecret = trim((string) config('zeptomail.oauth_client_secret'));
        $refreshToken = trim((string) config('zeptomail.oauth_refresh_token'));

        if ($clientId !== '' && $clientSecret !== '' && $refreshToken !== '') {
            return (string) Cache::remember('zeptomail:invoice-logs:oauth-token', 3000, function () use ($clientId, $clientSecret, $refreshToken) {
                $tokenUrl = config('zeptomail.oauth_token_url', 'https://accounts.zoho.com/oauth/v2/token');

                $response = $this->client->post($tokenUrl, [
                    'form_params' => [
                        'refresh_token' => $refreshToken,
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'grant_type' => 'refresh_token',
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'http_errors' => false,
                ]);

                $statusCode = $response->getStatusCode();
                $body = json_decode((string) $response->getBody(), true);
                $token = trim((string) data_get($body, 'access_token'));

                if ($statusCode < 200 || $statusCode >= 300 || $token === '') {
                    $message = data_get($body, 'error', 'Could not refresh ZeptoMail OAuth token.');
                    throw new RuntimeException((string) $message);
                }

                return $token;
            });
        }

        return $this->staticOauthToken;
    }
}
