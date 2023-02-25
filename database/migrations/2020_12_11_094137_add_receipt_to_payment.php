<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiptToPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('add_receipt')->nullable()->after('reference');
        });

        Schema::table(
            'revenues', function (Blueprint $table){
            $table->string('add_receipt')->nullable()->after('reference');
        });
        Schema::table(
            'invoice_payments', function (Blueprint $table){
            $table->string('add_receipt')->nullable()->after('reference');
        });
        Schema::table(
            'bill_payments', function (Blueprint $table){
            $table->string('add_receipt')->nullable()->after('reference');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
        Schema::table('revenues', function (Blueprint $table) {
            //
        });
        Schema::table('invoice_payments', function (Blueprint $table) {
            //
        });
        Schema::table('bill_payments', function (Blueprint $table) {
            //
        });
    }
}
