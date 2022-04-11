<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerIdColumnToOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders__products', function (Blueprint $table) {
            $table->bigInteger('seller_id')->default(0);
            $table->string('seller_read')->default('no');
            $table->integer('order_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders__products', function (Blueprint $table) {
            $table->dropColumn('seller_id');
            $table->dropColumn('seller_read');
            $table->dropColumn('order_time');
        });
    }
}
