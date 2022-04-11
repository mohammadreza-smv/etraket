<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders__products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('product_id');
            $table->integer('product_count');
            $table->integer('preparation_time')->default(0);
            $table->integer('send_status')->default(0);
            $table->integer('time')->default(0);
            $table->morphs('param1');
            $table->morphs('param2');
            $table->integer('product_price1');
            $table->integer('product_price2');
            $table->bigInteger('price_variation_id');
            $table->bigInteger('submission_id')->unsigned();
            $table->foreign('submission_id')->references('id')
                ->on('orders__submission')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders__products');
    }
}
