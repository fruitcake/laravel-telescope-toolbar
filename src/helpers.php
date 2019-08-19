<?php

if ( ! function_exists('debug')) {

    function debug(...$args) {
        \Fruitcake\TelescopeToolbar\Toolbar::dump(...$args);
    }
}
