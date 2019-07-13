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
            $table->integer('total_price')->unsigned();
            $table->integer('shipping_price')->unsigned()->nullable();
            $table->integer('points')->unsigned()->default(0);
            $table->timestamp('shipping_date')->nullable();
            $table->text('comment')->nullable();
            // cash on deleviry
            $table->string('payment_method')->default('COD');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('user_address_id')->unsigned()->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_address_id')->references('id')->on('user_addresses')->onUpdate('cascade')->onDelete('set null');
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
