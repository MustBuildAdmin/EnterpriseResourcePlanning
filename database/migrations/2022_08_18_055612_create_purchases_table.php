<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id')->default('0');
            $table->integer('vender_id');
            $table->integer('warehouse_id');
            $table->date('purchase_date');
            $table->integer('purchase_number')->default('0');
            $table->integer('status')->default('0');
            $table->integer('shipping_display')->default('1');
            $table->date('send_date')->nullable();
            $table->integer('discount_apply')->default('0');
            $table->integer('category_id');
            $table->integer('created_by')->default('0');
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
        Schema::dropIfExists('purchases');
    }
}
