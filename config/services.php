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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    'facebook' => [
        'client_id' => '810141006983359',  //client face của bạn
        'client_secret' => 'ccdfc8274accd9398e868149cacd2cb5',  //client app service face của bạn
        'redirect' => 'http://localhost/LaptopStore/admin/callback' //callback trả về
    ],

    'google' => [
        'client_id' => '451074060563-veakkhc6v9suu8gcqj4ddp2hqq0mb9id.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/laptopstore/customer/google/callback',
        'redirect_admin' => 'http://localhost/laptopstore/google/callback'
    ],



];
