<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullabe();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('main_location')->unsigned()->nullable();
            // added by email or mobile phone
            $table->string('added_by')->default('email');
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            // $table->foreign('main_location')->references('id')->on('user_addresses')->onUpdate('cascade')->onDelete('set  null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
