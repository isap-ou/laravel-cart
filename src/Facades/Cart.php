<?php

namespace Isapp\LaravelCart\Facades;

use Illuminate\Support\Facades\Facade;
use Isapp\LaravelCart\Contracts\CartItemContract;

/**
 * @method static \Isapp\LaravelCart\Contracts\Driver driver(string|null $driver = null)
 * @method static \Isapp\LaravelCart\Contracts\Driver storeItem(CartItemContract $item)
 * @method static \Isapp\LaravelCart\Contracts\Driver increaseQuantity(CartItemContract $item, int $quantity = 1)
 * @method static \Isapp\LaravelCart\Contracts\Driver get()
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-cart';
    }
}
