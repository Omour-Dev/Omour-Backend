<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('unread')->default(false);
            $table->boolean('is_holding')->default(false);
            $table->decimal('subtotal',9,3)->default(0.000);
            $table->decimal('discount',9,3)->default(0.000);
            $table->decimal('total',9,3)->default(0.000);

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('order_status_id')->unsigned();

            $table->foreign('user_id')->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('vendor_id')->references('id')
            ->on('vendors')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('order_status_id')->references('id')
            ->on('order_statuses')
            ->onUpdate('cascade')
            ->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
}
