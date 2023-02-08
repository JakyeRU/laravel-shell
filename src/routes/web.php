<?php

use Illuminate\Support\Facades\Route;
use Jakyeru\LaravelShell\Http\Livewire\Terminal;

/*
|--------------------------------------------------------------------------
| Laravel Shell Routes
|--------------------------------------------------------------------------
| These are the routes used by Laravel Shell.
|
*/

Route::group(config('laravel-shell.route'), function () {
    Route::get('/', Terminal::class)->name('laravel-shell.terminal');
});

require __DIR__.'/assets.php';