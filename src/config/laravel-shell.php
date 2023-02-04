<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Shell Enabled
    |--------------------------------------------------------------------------
    |
    | This option controls whether the Laravel Shell is enabled or not.
    |
    */

    'enabled' => env('LARAVEL_SHELL_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the route that will be used to access Laravel
    | Shell.
    |
    */

    'route' => [
        'prefix' => 'laravel-shell',
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Commands
    |--------------------------------------------------------------------------
    |
    | Here you may configure the custom commands that will be available in
    | Laravel Shell.
    |
    */

    'commands' => [
        // \App\Commands\CustomCommand::class,
    ],

];