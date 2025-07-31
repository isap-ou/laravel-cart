<?php

namespace Isapp\LaravelCart;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Isapp\LaravelCart\Manager\CartManager;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-cart');

        $this->app->bind('laravel-cart', function (Application $app) {
            return new CartManager($app);
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('laravel-cart.php'),
        ], 'config');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);
    }
}
