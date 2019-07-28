<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOSWorkerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_o_s_worker_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->string('building');
            $table->string('floor');
            $table->string('apartment');
            $table->string('nearest_landmark')->nullable();
            $table->string('location_type');
            $table->bigInteger('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('p_o_s_workers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('p_o_s_worker_addresses');
    }
}
