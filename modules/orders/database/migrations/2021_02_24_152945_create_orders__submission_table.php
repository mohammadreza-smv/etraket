<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders__submission', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->bigInteger('order_id')->unsigned();
            $table->string('delivery_order_interval')->nullable();
            $table->string('send_order_amount')->nullable();
            $table->string('send_status');
            $table->string('send_type')->nullable();
            $table->smallInteger('send_amount_type')->default(0);
            $table->integer('order_send_time');
            $table->bigInteger('user_id')->nullable();
            $table->foreign('order_id')->references('id')
                ->on('orders__list')
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
        Schema::dropIfExists('orders__submission');
    }
}
