<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOSWorkerPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_o_s_worker_personal_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('gender');
            $table->timestamp('birth_date');
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
        Schema::dropIfExists('p_o_s_worker_personal_infos');
    }
}
