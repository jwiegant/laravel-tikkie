<?php

return [
    /**
     * Sandbox
     * Use the ABNAMRO sandbox environment.
     */
    'sandbox' => env('TIKKIE_SANDBOX', false),

    /**
     * Do we want to enable the tikkie notification route ?
     * POST to /tikkie/notification.
     */
    'add_tikkie_notification_route' => env('TIKKIE_ADD_ROUTE', false),

    /**
     * API Key
     * Your API Key can be found in the ABNAMRO developer, My Apps, Create or Open your App.
     */
    'api-key' => env('TIKKIE_API_KEY', ''),

    /**
     * App Token
     * Can be created for the sandbox environment with the command: php artisan tikkie:createapp
     * For production the App Token is created in the Business Portal.
     */
    'app-token' => env('TIKKIE_APP_TOKEN', ''),
];
