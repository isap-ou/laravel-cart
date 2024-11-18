<?php

namespace IsapOu\LaravelCart\Drivers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use IsapOu\LaravelCart\Contracts\CartItemContract;
use IsapOu\LaravelCart\Contracts\Driver;

use function config;

class DatabaseDriver implements Driver
{
    protected function getCartModel(): Builder
    {
        $class = config('laravel-cart.drivers.database.cart_model');

        return $class::query();
    }

    public function get(?Authenticatable $user = null): Model
    {
        return $this->getCartModel()->with('items')->firstOrCreate(['user_id' => $user?->id]);
    }

    /**
     * Store item in cart.
     */
    public function storeItem(CartItemContract $item, ?Authenticatable $user = null): Driver
    {
        /** @var \IsapOu\LaravelCart\Models\Cart $cart */
        $cart = $this->getCartModel()->firstOrCreate(['user_id' => $user?->id]);
        $cart->storeItem($item);

        return $this;
    }

    /**
     * Store multiple items in cart.
     */
    public function storeItems(Collection $items, ?Authenticatable $user = null): static
    {
        $cart = $this->getCartModel()->firstOrCreate(['user_id' => $user?->id]);

        $items->each(fn (CartItemContract $item) => $cart->storeItem($item));

        return $this;
    }

    /**
     * Increase the quantity of the item.
     */
    public function increaseQuantity(CartItemContract $item, ?Authenticatable $user = null, int $quantity = 1): static
    {
        $cart = $this->getCartModel()->firstOrCreate(['user_id' => $user->getKey()]);
        $item = $cart->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->increment('quantity', $quantity);

        return $this;
    }

    /**
     * Decrease the quantity of the item.
     */
    public function decreaseQuantity(CartItemContract $item, ?Authenticatable $user = null, int $quantity = 1): static
    {
        $cart = $this->getCartModel()->firstOrCreate(['user_id' => $user?->getKey()]);
        $item = $cart->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->decrement('quantity', $quantity);

        return $this;
    }

    /**
     * Remove a single item from the cart
     */
    public function removeItem(CartItemContract $item, ?Authenticatable $user = null): static
    {
        $cart = $this->getCartModel()->firstOrCreate(['user_id' => $user?->getKey()]);

        $cart->items()->find($item->getKey())?->delete();

        return $this;
    }

    /**
     * Remove every item from the cart
     */
    public function emptyCart(?Authenticatable $user = null): static
    {
        $this->getCartModel()
            ->firstWhere(['user_id' => $user?->getKey()])
            ?->items()
            ->delete();

        return $this;
    }
}
