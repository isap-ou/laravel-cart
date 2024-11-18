<?php

namespace IsapOu\LaravelCart\Facades;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Facade;
use IsapOu\LaravelCart\Contracts\CartItemContract;

/**
 * @method static \IsapOu\LaravelCart\Contracts\Driver driver(string|null $driver = null)
 * @method static \IsapOu\LaravelCart\Contracts\Driver storeItem(CartItemContract $item, ?AuthenticatableContract $user)
 * @method static \IsapOu\LaravelCart\Contracts\Driver increaseQuantity(CartItemContract $item, AuthenticatableContract $user, int $quantity = 1)
 * @method static \IsapOu\LaravelCart\Contracts\Driver get(?AuthenticatableContract $user)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-cart';
    }
}
