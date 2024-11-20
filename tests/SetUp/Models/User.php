<?php

namespace IsapOu\LaravelCart\Tests\SetUp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IsapOu\LaravelCart\Tests\SetUp\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Fillable columns.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    public static $factory = UserFactory::class;
}
