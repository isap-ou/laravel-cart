<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('laravel-cart.cart_table_name'), function (Blueprint $table) {
            $table->id();
            if (! empty(config('laravel-cart.migration.users'))) {
                $table->foreignId(config('laravel-cart.migration.users.foreign_key'))
                    ->nullable()
                    ->comment('By default user id is nullable because its allowed add item to cart as guest')
                    ->constrained(config('laravel-cart.migration.users.table'))
                    ->cascadeOnDelete();
            }
            if (! empty(config('laravel-cart.migration.teams'))) {
                $table->foreignId(config('laravel-cart.migration.teams.foreign_key'))
                    ->nullable(config('laravel-cart.migration.teams.nullable'))
                    ->constrained(config('laravel-cart.migration.teams.table'))
                    ->cascadeOnDelete();
            }
            $table->string('session_id')
                ->nullable()
                ->index()
                ->comment('Session id should be filled, if user is guest');
            $table->unsignedTinyInteger('decimal_places')
                ->default(config('laravel-cart.migration.decimal_places'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((config('laravel-cart.cart_table_name')));
    }
};
