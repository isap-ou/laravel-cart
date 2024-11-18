<?php

namespace IsapOu\LaravelCart\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface Driver
{
    public function storeItem(CartItemContract $item, ?Authenticatable $user = null): Driver;

    public function storeItems(Collection $items): Driver;

    public function increaseQuantity(CartItemContract $item, ?Authenticatable $user = null, int $quantity = 1): Driver;

    public function decreaseQuantity(CartItemContract $item, ?Authenticatable $user = null, int $quantity = 1): Driver;

    public function removeItem(CartItemContract $item, ?Authenticatable $user = null): Driver;

    public function emptyCart(?Authenticatable $user = null): Driver;

    public function get(?Authenticatable $user = null): Model;
}
