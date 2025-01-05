<?php

namespace Isapp\LaravelCart\Contracts;

interface CartItemProduct
{
    public function getPrice(bool $incTaxes = true);
}
