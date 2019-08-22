<?php

Route::get('/render/{token}', 'ToolbarController@render')->name('telescope-toolbar.render');
Route::get('/show/{token}/{tab?}', 'ToolbarController@show')->name('telescope-toolbar.show');
Route::get('/assets/base.js', 'ToolbarController@baseJs')->name('telescope-toolbar.baseJs');
Route::get('/assets/styling.css', 'ToolbarController@styling')->name('telescope-toolbar.styling');