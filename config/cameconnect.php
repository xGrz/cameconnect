<?php

return [
    'host' => env('CAMECONNECT_HOST', 'https://cameconnect.net'),
    'username' => env('CAMECONNECT_USER', ''),
    'password' => env('CAMECONNECT_PASSWORD', ''),
    'client_id' => env('CAMECONNECT_CLIENT_ID', ''),
    'client_secret' => env('CAMECONNECT_CLIENT_SECRET', ''),
    'redirect_uri' => env('CAMECONNECT_REDIRECT_URI', 'https://www.cameconnect.net/role'),
    'urlAuthorize' => env('CAMECONNECT_AUTHORIZE_URL', 'https://app.cameconnect.net/api/oauth/auth-code'),
    'urlAccessToken' => env('CAMECONNECT_ACCESS_TOKEN_URL', 'https://app.cameconnect.net/api/oauth/token'),
];
