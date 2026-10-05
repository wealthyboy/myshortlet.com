<?php

return [
    'token' => env('ZEPTO_TOKEN'),

    // Email-log delivery tracking. A static OAuth access token can be used for
    // testing. For production, refresh credentials are preferred so the app
    // can renew the short-lived access token automatically.
    'logs_oauth_token' => env('ZEPTO_LOGS_OAUTH_TOKEN', env('ZEPTO_TOKEN')),
    'logs_url' => env('ZEPTO_LOGS_URL', 'https://cpaas.zoho.com/v1.1/email'),
    'oauth_client_id' => env('ZEPTO_OAUTH_CLIENT_ID'),
    'oauth_client_secret' => env('ZEPTO_OAUTH_CLIENT_SECRET'),
    'oauth_refresh_token' => env('ZEPTO_OAUTH_REFRESH_TOKEN'),
    'oauth_token_url' => env('ZEPTO_OAUTH_TOKEN_URL', 'https://accounts.zoho.com/oauth/v2/token'),

    'from' => [
        'address' => 'info@avenuemontaigne.ng',
        'name' => 'Avenue Montaigne',
    ],
    'base_url' => 'https://api.zeptomail.com/v1.1/email',
];
