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
            $table->bigInteger('total_quantity')->unsigned()->default(0);
            $table->bigInteger('low_quantity')->unsigned();
            $table->bigInteger('quantity_per_packet')->unsigned();
            $table->bigInteger('min_sale_quantity')->unsigned()->nullable();
            // sale by unit or gram
            $table->string('sale_by')->default('unit');
            $table->string('upc')->nullable();
            $table->string('sku')->nullable();
            $table->integer('cost')->unsigned();
            $table->integer('price')->unsigned();
            $table->integer('weight')->unsigned()->nullable();
            $table->integer('length')->unsigned()->nullable();
            $table->integer('width')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->integer('expiry_alarm_before')->unsigned();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('free_shipping')->default(0);
            $table->boolean('allow_review')->default(1);
            $table->boolean('allow_points')->default(1);
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null')->onUpdate('cascade');
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
