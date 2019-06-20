<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->bigInteger('quantity')->unsigned();
            $table->integer('low_quantity')->unsigned();
            $table->integer('quantity_per_packet')->unsigned();
            $table->integer('min_sale_quantity')->unsigned()->nullable();
            $table->string('SKU')->nullable();
            $table->integer('cost')->unsigned();
            $table->integer('price')->unsigned();
            $table->integer('weight')->unsigned()->nullable();
            $table->integer('length')->unsigned()->nullable();
            $table->integer('width')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->bigInteger('brand_id')->unsigned();
            $table->boolean('active')->default(1);
            $table->boolean('free_shipping')->default(0);
            $table->boolean('allow_review')->default(1);
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
}
