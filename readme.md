## Laravel Telescope Toolbar
![Unit Tests](https://github.com/fruitcake/laravel-telescope-toolbar/workflows/Unit%20Tests/badge.svg)
[![Packagist License](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/version.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)
[![Total Downloads](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/d/total.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)
[![Fruitcake](https://img.shields.io/badge/Powered%20By-Fruitcake-b2bc35.svg)](https://fruitcake.nl/)


### Extends Laravel Telescope to show a powerful Toolbar
See https://github.com/laravel/telescope

#### Install

First install Telescope and check it works (see https://laravel.com/docs/master/telescope)

```bash
composer require laravel/telescope
php artisan telescope:install

# Telescope 5.0 no longer automatically loads migrations from its own migrations directory. Instead, you should run the following command to publish Telescope's migrations to your application:
php artisan vendor:publish --tag=telescope-migrations

php artisan migrate
```

Then just install the package with Composer and it will register automatically:

```bash
composer require fruitcake/laravel-telescope-toolbar --dev
```

The Toolbar will show by default when Telescope is enabled and APP_DEBUG is true.
It can also enabled or disabled using the `TELESCOPE_TOOLBAR_ENABLED` environment variable.

![image](https://user-images.githubusercontent.com/973269/63676710-d79ad000-c7eb-11e9-8793-c58c6bc25bbe.png)

> Note: The Toolbar is intended for Development environments, not for production.

## Publishing the config

Run this command to publish the config for this package:

```php
php artisan vendor:publish --provider="Fruitcake\\TelescopeToolbar\\ToolbarServiceProvider"
```

#### Current Features

 - Inject Toolbar for quick info
 - Show redirects and Ajax Requests
 - Link to related Telescope Entry page
 - Show up to 5 entries for collectors, link to details
 - Supported Collectors:
    * Request info / timing
    * User auth
    * Database queries
    * Laravel/php version
    * Cache hit/miss/set
    * Logger entries
    * Exceptions
    * Mails
    * Notifications
    * Jobs
    * Dumps (when watching the Dump screen, or using `debug(...$args)`)
    * Number of entries for: Commands/Models/Events
    
#### Screenshots

Ajax/ Redirects stack:

![image](https://user-images.githubusercontent.com/973269/63675364-ef248980-c7e8-11e9-8696-dbddd9feb4bd.png)

Preview for Exceptions/Mail/Notifications/Log entries with link to details:

![image](https://user-images.githubusercontent.com/973269/63676030-67d81580-c7ea-11e9-9526-129bec5187f9.png)

Counter for Queries (and Cache etc):

![image](https://user-images.githubusercontent.com/973269/63675578-68bc7780-c7e9-11e9-915d-b955dd070c94.png)


Catch `debug()`/`Toolbar::dump()` calls and show them directly in the Toolbar instead of the page:

![image](https://user-images.githubusercontent.com/973269/63676511-60653c00-c7eb-11e9-9b8e-9473964a29a8.png)

## Running the Test Suite

- Make sure ChromeDriver is up to date: `vendor/bin/dusk-updater detect --auto-update`
- Create the Sqlite database: `vendor/orchestra/testbench-dusk/create-sqlite-db`
- Run the tests: `composer test`
    
## License and attribution

Laravel Telescope Toolbar is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Based on Symfony Web Profiler and Laravel Telescope
The styling, javascript, some icons and html of the Toolbar and (part of) its Collectors are based on the Symfony Web Profiler.
JS/CSS is mostly copied and converted to Blade syntax. Collectors are modified to show Laravel data.
See https://github.com/symfony/web-profiler-bundle - Copyright (c) 2004-2019 Fabien Potencier

Data from collectors is provided by Laravel Telescope. Some styling/icons/logic are alse re-used.
See https://github.com/laravel/telescope - Copyright (c) Taylor Otwell
                                         
