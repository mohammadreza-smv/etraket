<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatisticsWeekVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics__week_visit', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->smallInteger('hour');
            $table->smallInteger('days_of_week');
            $table->bigInteger('view');
            $table->smallInteger('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics__week_visit');
    }
}
