<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pos_id')->default('0');
            $table->integer('product_id')->default('0');
            $table->integer('quantity')->default('0');
            $table->float('tax')->default('0.00');
            $table->float('discount')->default('0.00');
            $table->float('price')->default('0.00');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('pos_products');
    }
}
