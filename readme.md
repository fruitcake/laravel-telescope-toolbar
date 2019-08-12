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

![image](https://user-images.githubusercontent.com/973269/62854273-24ac7b80-bcef-11e9-9b31-5525a845d4d3.png)

> Note: The Toolbar is intended for Development environments, not for production.

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
    * Number of entries for: Dumps/Commands/Models/Events
    
#### Screenshots

Ajax/ Redirects stack:

![image](https://user-images.githubusercontent.com/973269/62854008-5bce5d00-bcee-11e9-95f8-1a93cdd0a9f3.png)

Exception with preview / link to Telescope:

![image](https://user-images.githubusercontent.com/973269/62854018-67ba1f00-bcee-11e9-99f6-9b1b8132bb4e.png)

Counter for Queries (and Cache etc):

![image](https://user-images.githubusercontent.com/973269/62854021-6ab50f80-bcee-11e9-891e-494ed89a8e48.png)

Preview for Mail/Notifications/Log entries with link to details:

![image](https://user-images.githubusercontent.com/973269/62854027-6d176980-bcee-11e9-9020-c80705160a25.png)

    
## License and attribution

Laravel Telescope Toolbar is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Based on Symfony Web Profiler and Laravel Telescope
The styling, javascript, some icons and html of the Toolbar and (part of) its Collectors are based on the Symfony Web Profiler.
JS/CSS is mostly copied and converted to Blade syntax. Collectors are modified to show Laravel data.
See https://github.com/symfony/web-profiler-bundle - Copyright (c) 2004-2019 Fabien Potencier

Data from collectors is provided by Laravel Telescope. Some styling/icons/logic are alse re-used.
See https://github.com/laravel/telescope - Copyright (c) Taylor Otwell
                                         
