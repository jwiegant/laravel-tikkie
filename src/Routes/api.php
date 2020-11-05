<?php

use Illuminate\Support\Facades\Route;

// Define the tikkie notification route
$middleware = ['api'];
$as = 'cloudmazing.tikkie.';
$namespace = '\\Cloudmazing\\Tikkie\\Controllers';

// Create the route
Route::group(compact('middleware', 'as', 'namespace'), function () {
    Route::post('api/tikkie/notification', [
        'uses' => 'TikkieNotificationController@notification',
        'as'   => 'notification', ]);
});
