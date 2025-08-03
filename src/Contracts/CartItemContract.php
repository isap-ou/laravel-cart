<?php

namespace Isapp\LaravelCart\Contracts;

/**
 * @property int|string $cart_id
 * @property string $itemable_type
 * @property int|string $itemable_id
 * @property $itemable
 * @property int $quantity
 * @property int $decimal_places
 */
interface CartItemContract
{
    public function itemable();

    public function getKey();
}
