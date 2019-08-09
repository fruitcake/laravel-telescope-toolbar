<?php

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

];