<?php

use Illuminate\Support\Facades\Route;
use Jakyeru\LaravelShell\Http\Controllers\AssetController;

/*
|--------------------------------------------------------------------------
| Assets Routes
|--------------------------------------------------------------------------
| These routes are used to serve the assets for the Laravel Shell.
|
*/

Route::group(config('laravel-shell.route'), function () {
    Route::get('assets/{asset}', [AssetController::class, 'serve'])->name('laravel-shell.assets.serve');
});