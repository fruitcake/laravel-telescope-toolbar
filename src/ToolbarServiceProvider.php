<?php

namespace Fruitcake\TelescopeToolbar;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;

class ToolbarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(Toolbar $toolbar)
    {
        if (! config('telescope.enabled') || ! config('telescope-toolbar.enabled') || ! config('app.debug')) {
            return;
        }

        $this->registerRoutes();
        $this->registerPublishing();

        if (! $this->runningApprovedRequest()) {
            return;
        }

        $this->registerResponseHandler($toolbar);
        $this->registerDumpWatcher();
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
        Route::group($this->assetsConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Http/assets.php');
        });

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }

    /**
     * Get the Telescope Toolbar assets route group configuration array.
     *
     * @return array
     */
    private function assetsConfiguration()
    {
        return [
            'namespace' => 'Fruitcake\TelescopeToolbar\Http\Controllers',
            'prefix' => config('telescope-toolbar.path') . '/assets',
            'middleware' => config('telescope-toolbar.asset_middleware', 'web'),
        ];
    }

    /**
     * Get the Telescope Toolbar route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Fruitcake\TelescopeToolbar\Http\Controllers',
            'prefix' => config('telescope-toolbar.path'),
            'middleware' => config('telescope-toolbar.middleware', 'telescope'),
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
     * Determine if the application is handling an approved request.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return bool
     */
    private function runningApprovedRequest()
    {
        return ! $this->app->runningInConsole() && ! $this->app['request']->is(
            array_merge([
                config('telescope.path').'*',
                'telescope-api*',
                'vendor/telescope*',
                'horizon*',
                'vendor/horizon*',
            ],
            config('telescope.ignore_paths', []),
            config('telescope-toolbar.ignore_paths', []))
        );
    }
    
    /**
     * Listen to the RequestHandled event to prepare the Response.
     *
     * @param \Fruitcake\TelescopeToolbar\Toolbar $toolbar
     *
     * @return void
     */
    private function registerResponseHandler(Toolbar $toolbar)
    {
        Event::listen(RequestHandled::class, function(RequestHandled $event) use ($toolbar) {
            Telescope::withoutRecording(function() use($event, $toolbar) {
                try {
                    $toolbar->modifyResponse($event->request, $event->response);
                } catch (\Throwable $e) {
                    logger("Cannot load Telescope Toolbar: " . $e->getMessage(), ['exception' => $e]);
                }
            });
        });
    }

    private function registerDumpWatcher()
    {
        if ($seconds = config('telescope-toolbar.dump_watcher')) {
            $seconds = is_int($seconds) ? $seconds : 60;
            Cache::put('telescope:dump-watcher', true, now()->addSeconds($seconds));
        }
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

        $this->app->singleton(Toolbar::class);
    }
}
