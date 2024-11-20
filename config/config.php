<?php

return [

    'default' => env('LARAVEL_CART_DRIVER', 'database'),

    'drivers' => [
        'database' => [
            'cart_model' => IsapOu\LaravelCart\Models\Cart::class,
            'cart_item_model' => IsapOu\LaravelCart\Models\CartItem::class,
        ],

        'redis' => [
        ],
    ],

    'models' => [
        'cart' => IsapOu\LaravelCart\Models\Cart::class,
        'cart_items' => IsapOu\LaravelCart\Models\CartItem::class,
        'user' => App\Models\User::class,
        'team' => null,
    ],

    'cart_table_name' => 'carts',

    'cart_items_table_name' => 'cart_items',

    'migration' => [
        'decimal_places' => 0,
        'quantity_decimal_places' => 0,
        'users' => [
            'table' => 'users',
            'foreign_key' => 'user_id',
        ],
        'carts' => [
            'table' => 'carts',
            'foreign_key' => 'cart_id',
        ],
        'teams' => false,
        // 'teams' => [
        //    'table' => 'teams',
        //    'nullable' => true,
        //    'foreign_key' => 'team_id',
        // ]
    ],

    'guard' => 'web',
];
