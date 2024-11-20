<?php

namespace IsapOu\LaravelCart\Tests\SetUp;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
