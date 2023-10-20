<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_option_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_product_option_id')->unsigned();
            $table->foreign('order_product_option_id')->references('id')->on('order_product_options')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('option_value_id')->unsigned();
            $table->foreign('option_value_id')->references('id')->on('option_values')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_product_option_values');
    }
}
