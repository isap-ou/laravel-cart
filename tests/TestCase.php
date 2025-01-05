<?php

namespace Isapp\LaravelCart\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Isapp\LaravelCart\Tests\SetUp\TestServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(TestServiceProvider::class);
        $this->artisan('migrate');
    }
}
