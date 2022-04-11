<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersSubmissionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders__submission_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->smallInteger('from');
            $table->smallInteger('to');
            $table->string('tozihat')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('submission_id')->unsigned();

            $table->foreign('submission_id')->references('id')
                ->on('orders__submission')->onDelete('cascade');

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders__submission_events');
    }
}
