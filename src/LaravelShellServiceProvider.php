<?php

namespace Jakyeru\LaravelShell;

use Illuminate\Support\ServiceProvider;

class LaravelShellServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfig();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishConfig();

        if (config('laravel-shell.enabled')) {
            $this->registerRoutes();
        }
    }

    /**
     * Register the package config.
     *
     * @return void
     */
    protected function mergeConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravel-shell.php', 'laravel-shell');
    }

    /**
     * Publish the package config.
     *
     * @return void
     */
    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__.'/config/laravel-shell.php' => config_path('laravel-shell.php'),
        ], 'config');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}