<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    |
    | Set both the site key and the secret key.
    |
    */
    'api_site_key' => env('RECAPTCHA_SITE_KEY', ''),
    'api_secret_key' => env('RECAPTCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | Choose which version of the reCAPTCHA you want to use.
    | Options: 2, 3
    |
    */
    'version' => env('RECAPTCHA_VERSION', 3),

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | Various options for the reCAPTCHA implementation.
    |
    */
    'options' => [
        'curl_timeout' => 10,
        'curl_verify' => true,
        'skip_ips' => [], // Skip validation for these IP addresses
    ],

    /*
    |--------------------------------------------------------------------------
    | Script URL
    |--------------------------------------------------------------------------
    |
    | The URL for the reCAPTCHA script.
    |
    */
    'script_url' => [
        2 => 'https://www.google.com/recaptcha/api.js',
        3 => 'https://www.google.com/recaptcha/api.js'
    ],

    /*
    |--------------------------------------------------------------------------
    | Verify URL
    |--------------------------------------------------------------------------
    |
    | The URL to verify the reCAPTCHA response.
    |
    */
    'verify_url' => [
        2 => 'https://www.google.com/recaptcha/api/siteverify',
        3 => 'https://www.google.com/recaptcha/api/siteverify'
    ],
];