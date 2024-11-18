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
        Schema::create(config('laravel-cart.cart_items_table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId(config('laravel-cart.migration.carts.foreign_key'))
                ->constrained(config('laravel-cart.migration.carts.table'))
                ->cascadeOnDelete();
            $table->string('itemable_type')->nullable();
            $table->string('itemable_id')->nullable();
            $table->unsignedInteger('quantity')->default(1);
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
        Schema::dropIfExists(config('laravel-cart.cart_items_table_name'));
    }
};
