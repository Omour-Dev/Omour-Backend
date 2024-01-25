<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceShippingToVendorAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_areas', function (Blueprint $table) {
            $table->decimal('shipping_price', 9, 3)->default(0.000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_areas', function (Blueprint $table) {
            $table->dropColumn('shipping_price');
        });
    }
}
