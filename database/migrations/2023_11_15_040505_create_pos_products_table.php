<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->integer('pos_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->integer('quantity')->default(0);
            $table->double('tax', 8, 2)->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->double('price', 8, 2)->default(0);
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
};
