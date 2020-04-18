# Laravel Tikkie

The package simply provides a Laravel service provider, facade and config file for the ABN-AMRO Tikkie's API v2. <https://github.com/cloudmazing/laravel-tikkie>

## Installation

You can install this package via Composer using:

```bash
composer require cloudmazing/laravel-tikkie
```

## Configuration

You need to publish the config file to `app/config/tikkie.php`. To do so, run:

```bash
php artisan vendor:publish --tag=tikkie-config
```

Now you need to set your configuration using **environment variables**.

```bash
TIKKIE_API_KEY=XXXXXXXXXXXXXXXXXXX
TIKKIE_APP_TOKEN=XXXXXXXXXXXXXXXXXXX
```
 
