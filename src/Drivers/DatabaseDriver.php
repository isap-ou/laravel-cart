<?php

namespace IsapOu\LaravelCart\Drivers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use IsapOu\LaravelCart\Contracts\CartItemContract;
use IsapOu\LaravelCart\Contracts\Driver;

use IsapOu\LaravelCart\Models\Cart;

use function config;

class DatabaseDriver implements Driver
{
    protected function getCartModel(): Builder
    {
        $class = config('laravel-cart.drivers.database.cart_model');

        return $class::query();
    }

    public function get(?Authenticatable $user = null): Model|Cart
    {
        return $this->getCartModel()
            ->with('items')
            ->when(
                ! empty($user),
                fn ($query) => $query->firstOrCreate(['user_id' => $user?->id]),
                fn ($query) => $query->firstOrCreate(['session_id' => Session::getId()])
            );
    }

    /**
     * Store item in cart.
     */
    public function storeItem(CartItemContract $item, ?Authenticatable $user = null): Driver
    {
        $this->get($user)->storeItem($item);

        return $this;
    }

    /**
     * Store multiple items in cart.
     */
    public function storeItems(Collection $items, ?Authenticatable $user = null): static
    {
        $cart = $this->get($user);

        $items->each(fn (CartItemContract $item) => $cart->storeItem($item));

        return $this;
    }

    /**
     * Increase the quantity of the item.
     */
    public function increaseQuantity(
        CartItemContract $item,
        ?Authenticatable $user = null,
        int $quantity = 1
    ): static {
        $item = $this->get($user)->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->increment('quantity', $quantity);

        return $this;
    }

    /**
     * Decrease the quantity of the item.
     */
    public function decreaseQuantity(
        CartItemContract $item,
        ?Authenticatable $user = null,
        int $quantity = 1
    ): Driver {
        $item = $this->get($user)->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->decrement('quantity', $quantity);

        return $this;
    }

    /**
     * Remove a single item from the cart
     */
    public function removeItem(
        CartItemContract $item,
        ?Authenticatable $user = null
    ): Driver {
        $this->get($user)
            ->items()
            ->find($item->getKey())
            ?->delete();

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
