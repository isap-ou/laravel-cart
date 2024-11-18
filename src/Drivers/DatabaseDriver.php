<?php

namespace IsapOu\LaravelCart\Drivers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use IsapOu\LaravelCart\Contracts\CartItemContract;
use IsapOu\LaravelCart\Contracts\Driver;
use IsapOu\LaravelCart\Models\Cart;

use function config;

class DatabaseDriver implements Driver
{
    protected ?Authenticatable $user = null;

    protected string $guard = 'web';

    public function __construct()
    {
        $this->guard = config('laravel-cart.guard');
    }

    public function getUser(): ?Authenticatable
    {
        if (! empty($this->user)) {
            return $this->user;
        }

        return Auth::guard($this->guard)->user();
    }

    public function setUser(Authenticatable $user): Driver
    {
        $this->user = $user;

        return $this;
    }

    public function setGuard($guard): Driver
    {
        $this->guard = $guard;

        return $this;
    }

    public function get(?Authenticatable $user = null): Model|Cart
    {
        return $this->getCartModel()
            ->with('items')
            ->when(
                ! empty($this->getUser()),
                fn ($query) => $query->firstOrCreate(['user_id' => $this->getUser()->getKey()]),
                fn ($query) => $query->firstOrCreate(['session_id' => Session::getId()])
            );
    }

    /**
     * Store item in cart.
     */
    public function storeItem(CartItemContract $item): Driver
    {
        $this->get()->storeItem($item);

        return $this;
    }

    /**
     * Store multiple items in cart.
     */
    public function storeItems(Collection $items): static
    {
        $cart = $this->get();

        $items->each(fn (CartItemContract $item) => $cart->storeItem($item));

        return $this;
    }

    /**
     * Increase the quantity of the item.
     */
    public function increaseQuantity(CartItemContract $item, int $quantity = 1): static
    {
        $item = $this->get()->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->increment('quantity', $quantity);

        return $this;
    }

    /**
     * Decrease the quantity of the item.
     */
    public function decreaseQuantity(CartItemContract $item, int $quantity = 1): Driver
    {
        $item = $this->get()->items()->find($item->getKey());

        if (! $item) {
            throw new \RuntimeException('The item not found');
        }

        $item->decrement('quantity', $quantity);

        return $this;
    }

    /**
     * Remove a single item from the cart
     */
    public function removeItem(CartItemContract $item): Driver
    {
        $this->get()->items()
            ->find($item->getKey())
            ?->delete();

        return $this;
    }

    /**
     * Remove every item from the cart
     */
    public function emptyCart(): static
    {
        $this->get()?->items()->delete();

        return $this;
    }

    protected function getCartModel(): Builder
    {
        $class = config('laravel-cart.drivers.database.cart_model');

        return $class::query();
    }
}
