<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ShoppingCart', function ($collection) {
            $collection->id();
            $collection->string('shop');
            $collection->double('amount');
            $collection->string('quantity');
            $collection->string('comment');
            $collection->string('product_id')->unique();
            $collection->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('ShoppingCart');
    }
}
