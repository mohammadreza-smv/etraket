<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('status')->default(-1);
            $table->integer('parent_id');
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('file')->nullable();
            $table->integer('user_id');
            $table->string('user_type');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->string('from_type');
            $table->string('to_type');
            $table->integer('time');
            $table->softDeletes();
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
        Schema::dropIfExists('messages');
    }
}
