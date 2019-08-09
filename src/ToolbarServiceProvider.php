<?php

namespace Fruitcake\TelescopeToolbar;

use Fruitcake\TelescopeToolbar\Http\Middleware\ToolbarMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ToolbarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if (! config('telescope.enabled') || ! config('telescope-toolbar.enabled') || ! config('app.debug')) {
            return;
        }

        $this->registerRoutes();
        $this->registerPublishing();
        $this->registerMiddleware();

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'telescope-toolbar'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }

    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Fruitcake\TelescopeToolbar\Http\Controllers',
            'prefix' => '_tt',
            'middleware' => 'telescope',
        ];
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/telescope-toolbar.php' => config_path('telescope-toolbar.php'),
            ], 'telescope-toolbar-config');
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerMiddleware()
    {
        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app[Kernel::class];

        $kernel->pushMiddleware(ToolbarMiddleware::class);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/telescope-toolbar.php', 'telescope-toolbar'
        );
    }
}