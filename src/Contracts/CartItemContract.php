<?php

namespace IsapOu\LaravelCart\Contracts;

/**
 * @property int|string $cart_id
 * @property string $itemable_type
 * @property int|string $itemable_id
 * @property int $quantity
 * @property int $decimal_places
 */
interface CartItemContract
{
    public function itemable(): ?\Illuminate\Database\Eloquent\Relations\MorphTo;
}
