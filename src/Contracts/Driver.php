<?php

namespace Isapp\LaravelCart\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface Driver
{
    public function storeItem(CartItemContract $item): Driver;

    public function storeItems(Collection $items): Driver;

    public function increaseQuantity(CartItemContract $item, int $quantity = 1): Driver;

    public function decreaseQuantity(CartItemContract $item, int $quantity = 1): Driver;

    public function removeItem(CartItemContract $item): Driver;

    public function emptyCart(): Driver;

    public function get(): Model;

    public function setUser(Authenticatable $user): Driver;

    public function setGuard($guard): Driver;

    public function getUser(): ?Authenticatable;

    public function getTotalPrice(bool $incTaxes = true): string;
}
