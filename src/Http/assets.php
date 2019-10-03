<?php

use Illuminate\Support\Facades\Route;

Route::get('base.js', 'ToolbarController@baseJs')->name('telescope-toolbar.baseJs');
Route::get('styling.css', 'ToolbarController@styling')->name('telescope-toolbar.styling');