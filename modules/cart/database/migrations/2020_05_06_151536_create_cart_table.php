<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('price_variation_id');
            $table->integer('param1_id')->nullable();
            $table->integer('param2_id')->nullable();
            $table->integer('count');
            $table->integer('user_id');
            $table->bigInteger('initial_amount')->nullable();
            $table->bigInteger('final_amount')->nullable();
            $table->string('product_status')->default('available');
            $table->smallInteger('type')->default(1);
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
        Schema::dropIfExists('cart');
    }
}
