# Blockade

#### A simple block for your Laravel app to prevent access without a known code, and to force to https if you wish.

## Installation

* Install Blockade using composer: `composer require konsulting/laravel-blockade`

* Add Blockade's Service Provider to `config/app.php`

```php
'providers' => [
    // Other service providers...

    Konsulting\Laravel\Blockade\BlockadeServiceProvider::class,
],
	
```

* Add the middleware to your `app/Http/Kernel.php`

```php
protected $middlewareGroups = [
        'web' => [
            ... Other middleware
            \Konsulting\Laravel\Blockade\IsBlocked::class,
            \Konsulting\Laravel\Blockade\ForceSecure::class,
        ],
        ... Other middleware groups
    ];
```
_Only add the middleware you want to use._

* Publish configuration and adjust for your site
`php artisan vendor:publish --provider=Konsulting\Laravel\Blockade\BlockadeServiceProvider --tag=config`

* Optionally publish views and adjust for your site
`php artisan vendor:publish --provider=Konsulting\Laravel\Blockade\BlockadeServiceProvider --tag=views`

## Configuration Options

There is a small set of configuration options.

**key** - the variable name for the 'unlock code' to be used when checking is the site is blocked.

**code** - the code that allows access, it can be set using the environment variable `BLOCKADE_CODE` in the `.env` file

**show_form** - should Blockade show a form for the user to enter the code? defaults to `false`

**not_blocked** - an array of url patterns that should not be blocked

**not_secure** - an array of url patterns that should not be forced to https

## Security

If you find any security issues, or have any concerns, please email [keoghan@klever.co.uk](keoghan@klever.co.uk), rather than using the issue tracker.

## Contributing

Contributions are welcome and will be fully credited. We will accept contributions by Pull Request. 

Please:

* Use the PSR-2 Coding Standard
* Add tests, if you’re not sure how, please ask.
* Document changes in behaviour, including readme.md.

## Testing
We use [PHPUnit](https://phpunit.de) and the excellent [orchestral/testbench](https://github.com/orchestral/testbench) 

Run tests using PHPUnit: `vendor/bin/phpunit`
