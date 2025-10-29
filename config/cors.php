<?php
return [
    'paths' => ['api/*', 'auth/*', 'sanctum/csrf-cookie', 'email/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://argillaceous-gwenn-overindulgent.ngrok-free.dev', // domain FE Next.js kamu
    ],
    'allowed_origins_patterns' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['*'],
    'max_age' => 0,
    'supports_credentials' => true, // true kalau pakai cookie/session
];
