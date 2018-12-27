# onlinenic-api
A simple and useful onlinenic standalone package (with laravel support)

since there was no library written for APIv4 of onlinenic i written one.
this package contains all methods described in their documentation, howevern it's poorly written and most of the endpoints
are now testable in sandbox mode.

[Onlinenice API v4 Documentation](https://www.onlinenic.com/cp_english/template_api/download/Onlinenic_API_v4.0_Reseller_Guide.pdf)

## Installation

The recommended way to install this library is through Composer:

`$ composer require pezhvak/onlinenic-api`

If you're not familiar with `composer` follow the installation instructions for
[Linux/Unix/Mac](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) or
[Windows](https://getcomposer.org/doc/00-intro.md#installation-windows), and then read the
[basic usage introduction](https://getcomposer.org/doc/01-basic-usage.md).

### Laravel 5.5 and up

You don't have to do anything else, this package uses the Package Auto-Discovery feature, and should be available as soon as you install it via Composer.

### Laravel 5.4 or 5.3

Add the following Service Provider to your **config/app.php** providers array:

`Pezhvak\OnlinenicApi\OnlinenicServiceProvider::class,`

### Publish Laravel Configuratino Files (All Versions)

`php artisan vendor:publish --provider="Pezhvak\OnlinenicApi\OnlinenicServiceProvider"`

### Environment Variables

```
ONLINENIC_SANDBOX=TRUE
ONLINENIC_ACCOUNT=
ONLINENIC_PASSWORD=
ONLINENIC_KEY=
```

## Standalone Usage

after installing with composer you can simply initiate a new instance of Onlinenic class:


```php
$onlinenic = new Pezhvak\OnlinenicApi\Onlinenic($account_id, $password, $api_key, $sandbox);
// use the method you want, ex:
var_dump($onlinenic->checkDomain('universe.space'));
```

## Laravel Usage

you can use dependency injection feature in any method of your controller or resolve it through laravel service container:

using dependency injection:
```php
Route::get('/', function (\Pezhvak\OnlinenicApi\Onlinenic $onlinenic) {
    dd($onlinenic->checkDomain('universe.space'));
});
```

using service container:
```php
$onlinenic = resolve('Pezhvak\\OnlinenicApi\\Onlinenic');
dd($onlinenic->checkDomain('universe.space'));
```

## Dependencies

The library uses [Guzzle](https://github.com/guzzle/guzzle) as its HTTP communication layer.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
