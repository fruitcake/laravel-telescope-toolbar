<?php

namespace Fruitcake\TelescopeToolbar\Tests;

use Fruitcake\TelescopeToolbar\Toolbar;
use Fruitcake\TelescopeToolbar\ToolbarServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Telescope\Storage\DatabaseEntriesRepository;
use Laravel\Telescope\TelescopeServiceProvider;

class BrowserTestCase extends \Orchestra\Testbench\Dusk\TestCase
{
    use RefreshDatabase;

    protected static $baseServeHost = '127.0.0.1';
    protected static $baseServePort = 9292;



    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/laravel/telescope/database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [TelescopeServiceProvider::class, ToolbarServiceProvider::class];
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
