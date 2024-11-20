<?php

namespace IsapOu\LaravelCart\Manager;

use Illuminate\Support\Manager;
use IsapOu\LaravelCart\Contracts\Driver;
use IsapOu\LaravelCart\Drivers\DatabaseDriver;
use IsapOu\LaravelCart\Drivers\RedisDatabaseDriver;

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
