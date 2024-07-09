<?php

use Illuminate\Support\Facades\Route;

function active_class($path, $active = 'active')
{
    return in_array(Route::currentRouteName(), (array) $path) ? $active : '';
}

function is_active_route($path)
{
    return in_array(Route::currentRouteName(), (array) $path) ? 'true' : 'false';

}

function show_class($path)
{
    return in_array(Route::currentRouteName(), (array) $path) ? 'show' : '';

}
