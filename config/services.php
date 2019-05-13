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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('APP_URL').env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('APP_URL').env('FACEBOOK_REDIRECT_URI'),
    ],

    'pay-pal' => [
        'account' => 'dev.xsaven-facilitator_api1.gmail.com',
        'password' => '36EXUVCMKZBXM5H6',
        'signature' => 'APKzkWbQVFKHhYjTwoqNp1.dzu1KA45o.5rq2ZRa9xRF0VUtCuwdJGC4',
        // 'accessToken' => 'access_token$sandbox$phtcn6m4mrwwcp7p$d0fb7aff0e86c83de8dc9aa53bcbfaae',
        'clientId' => 'AUd06VFwjlif-H641OwRU9hFbAgvYHpV19ybMeZS9J2QzFCxEWjsyW72vRwkOaAACkVhoyK9BdO6gvUp',
        'secret' => 'ENflkWis3WknLojc93ctP9MeQ4WGmlNpjDHmGoEWS_Juqo62gZsdvvRCG3zCPBjL2kbJQxYwUMz0la6D',
        'testMode' => true
    ]
];
