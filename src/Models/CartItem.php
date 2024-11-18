<?php

namespace IsapOu\LaravelCart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IsapOu\LaravelCart\Contracts\CartItemContract;
use IsapOu\LaravelCart\Database\Factories\CartItemFactory;

use function config;

class CartItem extends Model implements CartItemContract
{
    use HasFactory;

    protected static $factory = CartItemFactory::class;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_items_table_name', 'cart_items');
    }

    /**
     * Relation polymorphic, inverse one-to-one or many relationship.
     */
    public function itemable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relation one-to-many, Cart model.
     */
    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
