<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_category_id')->unsigned()->index();
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onUpdate('cascade')->onDelete('restrict');
            $table->string('prod_name'); 
            $table->string('prod_info'); 
            $table->string('base_price');
            $table->integer('status')->default(1);
            $table->string('url');
            $table->string('thumbnail');
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
        Schema::dropIfExists('product');
    }
}
