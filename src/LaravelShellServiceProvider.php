<?php

namespace Jakyeru\LaravelShell;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LaravelShellServiceProvider extends ServiceProvider
{
    /**
     * The current version of Laravel Shell.
     *
     * @var string
     */
    const VERSION = '1.1.1';

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
            $this->registerViews();
            $this->registerLivewireComponents();
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

    /**
     * Register the package views.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-shell');
    }

    /**
     * Register the livewire components.
     *
     * @return void
     */
    protected function registerLivewireComponents(): void
    {
        Livewire::component('terminal', \Jakyeru\LaravelShell\Http\Livewire\Terminal::class);
    }
}