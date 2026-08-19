<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'google_map' => ['map' => env('GOOGLE_MAP')],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.eu.mailgun.net'),
    ],
    'mailchimp' => [
        'secret' => env('MAILCHIMP_SECRET'),
        'list' => env('MAILCHIMP_LISTID'),
    ],
    'channex' => [
        'base_url' => env('CHANNEX_BASE_URL'),
        'key' => env('CHANNEX_API_KEY'),
        'webhook_secret' => env('CHANNEX_WEBHOOK_SECRET'),
        'webhook_secret_header' => env('CHANNEX_WEBHOOK_SECRET_HEADER', 'X-Channex-Webhook-Secret'),
        'ari_limit_per_minute' => env('CHANNEX_ARI_LIMIT_PER_MINUTE', 20),
        'ari_endpoint_limit_per_property' => env('CHANNEX_ARI_ENDPOINT_LIMIT_PER_PROPERTY', 10),
        'verification_token' => env('CHANNEX_VERIFICATION_TOKEN'),
    ],

    'live_export' => [
        'token' => env('LIVE_EXPORT_TOKEN'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_URL'),
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

];
