<?php
return [
    /*
    |--------------------------------------------------------------------------
    | CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for Cross-Origin Resource Sharing
    | (CORS). This determines which origins are allowed to access your API.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
