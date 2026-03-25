<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | File ini digunakan untuk menyimpan kredensial layanan pihak ketiga seperti
    | Mailgun, Postmark, AWS, dan lainnya. Lokasi ini memudahkan package
    | Socialite untuk menemukan kredensial berbagai layanan secara konvensional.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Socialite Services (Google & Apple)
    |--------------------------------------------------------------------------
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'), // Diambil dari file .env
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), // Diambil dari file .env
        'redirect' => env('GOOGLE_REDIRECT_URI'), // Diambil dari file .env
    ],

    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'), // Service ID Apple Anda
        'client_secret' => env('APPLE_CLIENT_SECRET'), // JWT Secret untuk Apple
        'redirect' => env('APPLE_REDIRECT_URI'), // URL Callback Apple
        
        // Tambahan khusus untuk provider socialiteproviders/apple
        'team_id' => env('APPLE_TEAM_ID'), // Team ID dari Apple Developer Portal
        'key_id' => env('APPLE_KEY_ID'), // Key ID dari Apple Developer Portal
        'private_key' => env('APPLE_PRIVATE_KEY'), // Path ke file .p8
    ],

];