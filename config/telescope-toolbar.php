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
    | Replace Toolbar with Ajax Request
    |--------------------------------------------------------------------------
    |
    | This options makes Ajax requests directly replace the current Toolbar
    |
    */
    'replace' => true,

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
    | Collectors
    |--------------------------------------------------------------------------
    |
    | This options configures which collectors are shown
    |
    */
    'collectors' => [
        EntryType::REQUEST => [
            'telescope-toolbar::collectors.request',
            'telescope-toolbar::collectors.time',
            'telescope-toolbar::collectors.user',
        ],
        EntryType::EXCEPTION => [
            'telescope-toolbar::collectors.exceptions',
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