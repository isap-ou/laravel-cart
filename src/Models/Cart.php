<?php

namespace IsapOu\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use IsapOu\LaravelCart\Contracts\CartItemContract;

use function config;

class Cart extends Model
{
    protected $fillable = [
        'decimal_places',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_table_name', 'carts');
        if (! empty(config('laravel-cart.migration.users'))) {
            $this->fillable[] = config('laravel-cart.migration.users.foreign_key', 'id');
        }
    }

    public function items(): HasMany
    {
        return $this->hasMany(config('laravel-cart.drivers.database.cart_items_model'));
    }

    /**
     * Store cart item in cart.
     */
    public function storeItem(CartItemContract $item): static
    {
        if (empty($item->itemable_id)) {
            $item->itemable_id = $item->itemable->getAttribute('id');
            $item->itemable_type = \get_class($item->itemable);
        }

        $this->items()->save($item);

        // Dispatch Event
        // LaravelCartStoreItemEvent::dispatch();

        return $this;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('laravel-cart.models.user'), config('laravel-cart.migration.users.foreign_key'));
    }
}
