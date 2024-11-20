<?php

namespace IsapOu\LaravelCart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IsapOu\LaravelCart\Concerns\HasCart;
use IsapOu\LaravelCart\Concerns\Itemable;
use IsapOu\LaravelCart\Contracts\CartItemContract;
use IsapOu\LaravelCart\Database\Factories\CartItemFactory;

use function config;

class CartItem extends Model implements CartItemContract
{
    use HasCart;
    use HasFactory;
    use Itemable;

    protected static $factory = CartItemFactory::class;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_items_table_name', 'cart_items');
    }

    /**
     * Relation one-to-many, Cart model.
     */
    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
