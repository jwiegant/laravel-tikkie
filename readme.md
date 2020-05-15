![Tikkie Logo][tikkie-logo]

# Laravel Tikkie
[![StyleCI][ico-styleci]][link-styleci]
[![Travis][ico-travis]][link-travis]
[![License][ico-license]][link-license]
[![FOSSA Status][ico-fossa]][link-fossa]
[![Codeclimate Badge][ico-codeclimate]][link-codeclimate]


The package simply provides a Laravel service provider, facade and config file for the ABN-AMRO Tikkie's API v2. 

[Check this link for more information on ABN-AMRO Tikkie.](https://developer.abnamro.com/api-products/tikkie)

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

Want to start in the sandbox first, then also set the following **variable**
```bash
TIKKIE_SANDBOX=true
```

## Notification / Subscription
ABNAMRO can provide a post request upon payment and refund. They provide the details 
which you can use to find the payment / refund in your own system and check the status 
at Tikkie.

We've implemented a post route to ```[your_website]/api/tikkie/notification``` which will
generate a Payment or Refund Event based on what's posted. 

To use this route also add to your .env file 
```bash
TIKKIE_ADD_ROUTE=true
```     

Check out the [documentation](docs/Subscription.md) for more information.

## Documentation
[Read the documentation](docs/Tikkie.md)
 
### Example
Want to [create an example application](docs/Example.md)?  

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## License

Please see the [license file](license.md) for more information.

[tikkie-logo]: img/TikkieAPI.png

[ico-license]: https://poser.pugx.org/jwiegant/laravel-tikkie/license
[link-license]: https://github.com/jwiegant/laravel-tikkie/blob/HEAD/license.md
[ico-travis]: https://travis-ci.org/jwiegant/laravel-tikkie.svg?branch=master
[link-travis]: https://travis-ci.org/github/jwiegant/laravel-tikkie
[ico-styleci]: https://github.styleci.io/repos/256785939/shield?branch=master
[link-styleci]: https://github.styleci.io/repos/256785939
[ico-fossa]: https://app.fossa.io/api/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie.svg?type=shield
[link-fossa]: https://app.fossa.io/projects/git%2Bgithub.com%2Fjwiegant%2Flaravel-tikkie?ref=badge_shield
[ico-codacy]: https://api.codacy.com/project/badge/Grade/63ad808eb0554709bf7751908a925de0
[link-codacy]: https://www.codacy.com/manual/jwiegant/laravel-tikkie?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jwiegant/laravel-tikkie&amp;utm_campaign=Badge_Grade
[ico-codeclimate]: https://api.codeclimate.com/v1/badges/dcf531a11061fd7a13c4/maintainability
[link-codeclimate]: https://codeclimate.com/github/jwiegant/laravel-tikkie/maintainability
