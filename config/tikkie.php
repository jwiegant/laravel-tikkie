<?php

return [

    /**
     * API Key
     * Your API Key can be found in the ABNAMRO developer, My Apps, Create or Open your App
     */
    'api-key'   => env('TIKKIE_API_KEY', ''),

    /**
     * App Token
     * Can be created for the sandbox environment with the command: php artisan tikkie:createapp
     * For production the App Token is created in the Business Portal
     */
    'app-token' => env('TIKKIE_APP_TOKEN', ''),

    'sandbox' => env('TIKKIE_SANDBOX', false),
];
