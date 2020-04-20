# Laravel Tikkie

[![License][ico-travis]][link-travis]
[![License][ico-license]][link-license]
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie?ref=badge_shield)

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
## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## License

Please see the [license file](license.md) for more information.

[ico-license]: https://poser.pugx.org/jwiegant/laravel-tikkie/license
[link-license]: https://github.com/jwiegant/laravel-tikkie/blob/HEAD/license.md
[ico-travis]: https://travis-ci.org/jwiegant/laravel-tikkie.svg?branch=master
[link-travis]: https://travis-ci.org/github/jwiegant/laravel-tikkie


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie?ref=badge_large)