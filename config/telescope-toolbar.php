<?php

use Laravel\Telescope\EntryType;

return [

    /*
    |--------------------------------------------------------------------------
    | Telescope Toolbar Enabled
    |--------------------------------------------------------------------------
    |
    | This options disables the toolbar. Laravel Telescope needs to be
    | enabled and Laravel needs to be in Debug mode.
    |
    */
    'enabled' => env('TELESCOPE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Use Telescope Theme ('light mode')
    |--------------------------------------------------------------------------
    |
    | This options disables the toolbar. Laravel Telescope needs to be
    | enabled and Laravel needs to be in Debug mode.
    |
    */
    'light_theme' => true,

    /*
    |--------------------------------------------------------------------------
    | Route path of Toolbar
    |--------------------------------------------------------------------------
    |
    | The route path that is being used to collect the toolbar metrics.
    |
    */
    'path' => '_tt',

    /*
     |--------------------------------------------------------------------------
     | Middleware of Toolbar
     |--------------------------------------------------------------------------
     |
     | The middleware that is used for the Telescope API routes. By default
     | it will use the Telescope middleware.
     |
     */
    'middleware' => [
        'telescope'
    ],

    'asset_middleware' => [
        'web'
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Ajax Paths
    |--------------------------------------------------------------------------
    |
    | This Javascript RegExp excludes Ajax Requests from being collected.
    |
    */
    'excluded_ajax_paths' => '^/_tt|^/_debugbar',

    /*
    |--------------------------------------------------------------------------
    | Store Redirects in Session
    |--------------------------------------------------------------------------
    |
    | This options stores Redirect responses in the Session to show
    | them in in the Requests tab on the next 'real' response.
    |
    */
    'store_redirects' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Dump Watcher
    |--------------------------------------------------------------------------
    |
    | This options listens for dumps always, without having the tab open.
    | You can specify the number of seconds it listens or disable with `false`
    |
    */
    'dump_watcher' => false,

    /*
    |--------------------------------------------------------------------------
    | Collectors
    |--------------------------------------------------------------------------
    |
    | This options configures which collectors are shown
    |
    */
    'collectors' => [
        EntryType::REQUEST => [
            'telescope-toolbar::collectors.request',
            'telescope-toolbar::collectors.session',
            'telescope-toolbar::collectors.user',
            'telescope-toolbar::collectors.time',
        ],
        EntryType::EXCEPTION => [
            'telescope-toolbar::collectors.exceptions',
        ],
        EntryType::VIEW => [
            'telescope-toolbar::collectors.views',
        ],
        EntryType::QUERY => [
            'telescope-toolbar::collectors.queries',
        ],
        EntryType::CACHE => [
            'telescope-toolbar::collectors.cache',
        ],
        EntryType::LOG => [
            'telescope-toolbar::collectors.logs',
        ],
        EntryType::MAIL => [
            'telescope-toolbar::collectors.mail',
        ],
        EntryType::NOTIFICATION => [
            'telescope-toolbar::collectors.notifications',
        ],
        EntryType::GATE => [
            'telescope-toolbar::collectors.gates',
        ],
        EntryType::JOB => [
            'telescope-toolbar::collectors.jobs',
        ],
        EntryType::COMMAND => [
            'telescope-toolbar::collectors.commands',
        ],
        EntryType::DUMP => [
            'telescope-toolbar::collectors.dumps',
        ],
        EntryType::EVENT => [
            'telescope-toolbar::collectors.events',
        ],
        EntryType::MODEL => [
            'telescope-toolbar::collectors.models',
        ],
        EntryType::REDIS => [
            'telescope-toolbar::collectors.redis',
        ],
        EntryType::SCHEDULED_TASK => [

        ],
    ],

];
