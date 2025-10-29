<?php
return [
    'paths' => ['api/', 'auth/', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://hyperanabolic-camren-subzero.ngrok-free.dev', 'https://argillaceous-gwenn-overindulgent.ngrok-free.dev'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // true kalau pakai cookie/session
];