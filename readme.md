## Laravel Telescope Toolbar
[![Packagist License](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/version.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)
[![Total Downloads](https://poser.pugx.org/fruitcake/laravel-telescope-toolbar/d/total.png)](https://packagist.org/packages/fruitcake/laravel-telescope-toolbar)

### Extends Laravel Telescope to show a powerful Toolbar
See https://github.com/laravel/telescope

#### Install

Just install the package with Composer and it will register automatically:

```bash
composer require fruitcake/laravel-telescope-toolbar:1.x@dev --dev
```

The Toolbar will show by default when Telescope is enabled on APP_DEBUG is true.

![image](https://user-images.githubusercontent.com/973269/62824759-b35fb200-bba2-11e9-964b-cf40f3d6d79c.png)


#### Current Features

 - Inject Toolbar for quick info
 - Show redirects and Ajax Requests
 - Link to related Telescope Entry page
 - Supported Collectors:
    * Request info / timing
    * User auth
    * Database queries
    * Laravel/php version
    * Cache
    * Logger
    * Exceptions
    
#### Todo

Target is to support all tabs from Telescope that can be connected to the current 'batch'. So Cache, Mails, Exceptions etc.

Missing features
 - Toggle ajax requests?
 - Missing collectors

> Note: There is no stable release yet. Use with caution and only on Development environments.

## License and attribution

Laravel Telescope Toolbar is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Based on Symfony Web Profiler and Laravel Telescope
The styling, javascript, some icons and html of the Toolbar and (part of) its Collectors are based on the Symfony Web Profiler.
JS/CSS is mostly copied and converted to Blade syntax. Collectors are modified to show Laravel data.
See https://github.com/symfony/web-profiler-bundle - Copyright (c) 2004-2019 Fabien Potencier

Data from collectors is provided by Laravel Telescope. Some styling/icons/logic are alse re-used.
See https://github.com/laravel/telescope - Copyright (c) Taylor Otwell
                                         
