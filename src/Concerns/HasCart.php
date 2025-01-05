<?php

namespace Isapp\LaravelCart\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;

use function config;

trait HasCart
{
    public function cart(): HasOne
    {
        return $this->hasOne(config('laravel-cart.models.cart'));
    }
}
