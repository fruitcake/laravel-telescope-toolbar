## Laravel Telescope Toolbar
[![Packagist License](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/version.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)
[![Total Downloads](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/d/total.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)

### Extends Laravel Telescope to provide a simple Toolbar
See https://github.com/laravel/telescope

#### Install

Just install the package with Composer and it will register automatically:

```bash
composer require fruitcake/laravel-telescope-toolbar:1.x@dev --dev
```

The Toolbar will show by default when Telescope is enabled on APP_DEBUG is true.

#### Current Features

 - Inject Toolbar for quick info
 - Register Ajax requests and update info
 - Link to related Telescope Entry
 - Supported Collectors:
    * Request
    * User auth
    * Database
    * Laravel/php version
    
#### Todo

Target is to support all tabs from Telescope that can be connected to the current 'batch'. So Cache, Mails, Exceptions etc.

Missing features
 - Show redirects
 - Toggle ajax requests?
 - Missing collectors

> Note: There is no stable release yet. Use with caution and only on Development environments.

### Based on Symfony Web Profiler
The styling, javascript and html of the Toolbar and (part of) its Collectors are based on the Symfony Web Profiler.
JS/CSS is mostly copied and converted to Blade syntax. Collectors are modified to show Laravel data.
See https://github.com/symfony/web-profiler-bundle
Copyright (c) 2004-2019 Fabien Potencier