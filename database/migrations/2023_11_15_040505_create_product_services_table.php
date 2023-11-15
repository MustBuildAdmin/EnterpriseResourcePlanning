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
        Schema::create('product_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sku');
            $table->string('hsc');
            $table->decimal('sale_price', 16)->default(0);
            $table->decimal('purchase_price', 16)->default(0);
            $table->integer('quantity')->default(0);
            $table->string('tax_id', 50)->nullable()->default('0');
            $table->integer('category_id')->default(0);
            $table->integer('unit_id')->default(0);
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('pro_image')->nullable();
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('product_services');
    }
};
