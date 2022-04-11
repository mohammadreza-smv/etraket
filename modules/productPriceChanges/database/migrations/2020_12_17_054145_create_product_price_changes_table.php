<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPriceChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('time');
            $table->string('Year',10);
            $table->string('mount',10);
            $table->string('day',10);
            $table->integer('price');
            $table->integer('product_id');
            $table->integer('price_variation_id');
            $table->morphs('param1');
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
        Schema::dropIfExists('product_price_changes');
    }
}
