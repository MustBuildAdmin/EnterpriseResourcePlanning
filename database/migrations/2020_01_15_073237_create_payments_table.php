<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'payments', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->date('date');
            $table->float('amount',15,2)->default('0.00');
            $table->integer('account_id');
            $table->integer('vender_id');
            $table->text('description')->nullable();
            $table->integer('category_id');
            $table->string('recurring')->nullable();
            $table->integer('payment_method');
            $table->string('reference')->nullable();
            $table->integer('created_by')->default('0');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
