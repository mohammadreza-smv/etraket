<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockroomEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockroom_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('user_id');
            $table->integer('stockroom_id');
            $table->text('tozihat')->nullable();
            $table->integer('time');
            $table->smallInteger('product_count');
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
        Schema::dropIfExists('stockroom_events');
    }
}
