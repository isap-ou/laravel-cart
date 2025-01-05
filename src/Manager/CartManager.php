<?php

namespace Isapp\LaravelCart\Manager;

use Illuminate\Support\Manager;
use Isapp\LaravelCart\Contracts\Driver;
use Isapp\LaravelCart\Drivers\DatabaseDriver;
use Isapp\LaravelCart\Drivers\RedisDatabaseDriver;

class CartManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('laravel-cart.default');
    }

    protected function createDatabaseDriver(): Driver
    {
        return new DatabaseDriver();
    }

    protected function createRedisDriver(): Driver
    {
        return new RedisDatabaseDriver();
    }
}
