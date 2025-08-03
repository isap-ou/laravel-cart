<?php

namespace Isapp\LaravelCart\Facades;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Isapp\LaravelCart\Contracts\CartItemContract;
use Isapp\LaravelCart\Contracts\Driver;

/**
 * @method static Driver driver(string|null $driver = null)
 * @method static Model get()
 * @method static Driver setUser(Authenticatable $user)
 * @method static Driver setGuard(string $guard)
 * @method static Authenticatable|null getUser()
 * @method static Driver storeItem(CartItemContract $item)
 * @method static Driver storeItems(Collection $items)
 * @method static Driver increaseQuantity(CartItemContract $item, int $quantity = 1)
 * @method static Driver decreaseQuantity(CartItemContract $item, int $quantity = 1)
 * @method static Driver removeItem(CartItemContract $item)
 * @method static Driver emptyCart()
 * @method static string getTotalPrice(bool $incTaxes = true)
 * @method static string getItemPrice(CartItemContract $item, bool $incTaxes = true)
 * @method static string getItemPricePerUnit(CartItemContract $item, bool $incTaxes = true)
 * @method static CartItemContract|null getItem(CartItemContract|string|int $item)
 * @method static bool hasItem(CartItemContract|string|int $item)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-cart';
    }
}
