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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_id');
            $table->date('date');
            $table->double('amount', 8, 2)->default(0);
            $table->integer('account_id');
            $table->integer('payment_method');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->string('add_receipt')->nullable();
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
        Schema::dropIfExists('purchase_payments');
    }
};
