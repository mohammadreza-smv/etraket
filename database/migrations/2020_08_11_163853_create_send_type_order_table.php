<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendTypeOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_type_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_name');
            $table->string('type_key');
            $table->string('send_type_name')->nullable();
            $table->string('type_icon')->nullable();
            $table->integer('weight1')->default(0);
            $table->integer('weight2')->nullable();
            $table->smallInteger('price_type')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_type_order');
    }
}
