<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOSOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_o_s_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_price')->unsigned()->default(0);
            $table->text('comment')->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->bigInteger('worker_id')->unsigned()->nullable();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('worker_id')->references('id')->on('p_o_s_workers')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('p_o_s_orders');
    }
}
