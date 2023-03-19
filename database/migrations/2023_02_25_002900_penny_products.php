<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PennyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Penny_Products', function (Blueprint $table) {
            $table->id();
            $table->string('Category');
            $table->string('images');
            $table->string('name');
            $table->string('unitLong');
            $table->string('unitShort');
            $table->integer('unitPrice');
            $table->integer('price');
            $table->date('validityStart');
            $table->date('validityEnd');
            $table->boolean('isPublished');
            $table->string('volumeLabelLong');
            $table->string('weight');
            $table->boolen('published');
            $table->string('productMarketing');
            //$table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();*/
            $table->timestamps();
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
        Schema::dropIfExists('Penny_Products');
    }
}
