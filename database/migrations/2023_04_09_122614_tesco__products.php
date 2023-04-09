<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TescoProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Tesco_Products', function (Blueprint $table) {
            $table->id();
            $table->string('template');
            $table->string('name');
            $table->string('url');
            $table->boolean('active');
            $table->string('offerBegin');
            $table->string('offerEnd');
            $table->string('imageURL');
            $table->string('comment');
            $table->string('unit');
            $table->integer('bestUnitPrice');
            $table->integer('bestPrice');

            //$table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('Tesco_Products');
    }
}
