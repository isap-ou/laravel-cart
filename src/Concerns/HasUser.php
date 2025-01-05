<?php

namespace Isapp\LaravelCart\Concerns;

use function config;

trait HasUser
{
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('laravel-cart.models.user'), config('laravel-cart.migration.users.foreign_key'));
    }
}
