<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price',9,3);
            $table->decimal('off',9,3)->default(0.000);
            $table->integer('qty')->default(1);
            $table->decimal('total',9,3);
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_products');
    }
}
