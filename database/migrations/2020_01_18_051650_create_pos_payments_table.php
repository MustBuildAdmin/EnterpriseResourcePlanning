<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voi
     */
    public function up()
    {
        Schema::create(
            'pos_payments', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('pos_id');
            $table->date('date')->nullable();
            $table->string('amount')->default('0.00');
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
        Schema::dropIfExists('pos_payments');
    }
}
