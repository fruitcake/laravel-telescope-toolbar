<?php

namespace Fruitcake\TelescopeToolbar\Tests;

use Fruitcake\TelescopeToolbar\Toolbar;
use Fruitcake\TelescopeToolbar\ToolbarServiceProvider;

class BrowserTestCase extends \Orchestra\Testbench\Dusk\TestCase
{
    protected static $baseServeHost = '127.0.0.1';
    protected static $baseServePort = 9292;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ToolbarServiceProvider::class];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return ['Toolbar' => Toolbar::class];
    }
}
