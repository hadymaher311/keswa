<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOSWorkerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_o_s_worker_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('language')->default('en');
            $table->boolean('min_sidebar')->default(0);
            $table->bigInteger('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('p_o_s_workers')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('p_o_s_worker_settings');
    }
}
