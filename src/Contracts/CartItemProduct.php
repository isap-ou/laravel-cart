<?php

namespace IsapOu\LaravelCart\Contracts;

interface CartItemProduct
{
    public function getPrice(bool $incTaxes = true);
}
