<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProductPriceVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_price_variation', function (Blueprint $table) {
            $table->smallInteger('show_index')->default(0);
            $table->smallInteger('offers')->default(0);
            $table->string('offers_first_date')->nullable();
            $table->string('offers_last_date')->nullable();
            $table->integer('offers_first_time')->default(0);
            $table->integer('offers_last_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_price_variation', function (Blueprint $table) {
            $table->dropColumn('show_index');
            $table->dropColumn('offers');
            $table->dropColumn('offers_first_date');
            $table->dropColumn('offers_last_date');
            $table->dropColumn('offers_first_time');
            $table->dropColumn('offers_last_time');
        });
    }
}
