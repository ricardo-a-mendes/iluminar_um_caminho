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

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
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

    'facebook' => [
        'client_id' => '302422630383084',
        'client_secret' => '3fd21c5f86720533c78c74ac93439955',
        'redirect' => 'https://b2e48ddd.ngrok.io/login/facebook/callback',
    ],

//    'google' => [
//        'client_id' => '360865786227-onggi8p64vdvb03d4q7jsi74e1ap0g78.apps.googleusercontent.com',
//        'client_secret' => 'd1zyKxoBCendVW5L4qQUKiQX',
//        'redirect' => 'https://cc8c925e.ngrok.io/checkout',
//    ],

    'google' => [
        'client_id' => '360865786227-dle40r87g1hoeinl9bvl1lg1aea0a1rt.apps.googleusercontent.com',
        'client_secret' => '9Bej6N026AV_BnHAt64CeWlu',
        'redirect' => '/login/google/callback',
    ],

    'github' => [
        'client_id' => '80e6fc880d288a022e68',
        'client_secret' => '2d0cad17ad9154bcfbc9b889437b9f62c00319f9',
        'redirect' => 'https://b2e48ddd.ngrok.io/login/github/callback',
    ],

];
