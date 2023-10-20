<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_attribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('price',9,3)->default(0.000);
            $table->integer('qty');
            $table->decimal('total',9,3)->default(0.000);

            $table->bigInteger('order_product_attribute_id')->unsigned();

            $table->bigInteger('attribute_value_id')->unsigned();

            $table->foreign('attribute_value_id')
            ->references('id')->on('attribute_values')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('order_product_attribute_id', 'o_p_at_id')
            ->references('id')
            ->on('order_product_attributes')
            ->onUpdate('cascade')
            ->onDelete('cascade');

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
        Schema::dropIfExists('order_product_attributes');
    }
}
