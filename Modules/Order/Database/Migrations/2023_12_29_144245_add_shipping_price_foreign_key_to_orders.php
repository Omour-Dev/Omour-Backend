<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingPriceForeignKeyToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_price', 9, 3)->default(0.000);
            $table->bigInteger('vendor_area_id')->unsigned()->nullable();
            $table->foreign('vendor_area_id')->references('id')->on('vendor_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_price');
            $table->dropForeign(['vendor_area_id']);
            $table->dropColumn('vendor_area_id');
        });
    }
}
