<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceVal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'product_services', function (Blueprint $table){
            $table->decimal('sale_price', 16, 2)->default('0.0')->change();
            $table->decimal('purchase_price', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->decimal('price', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'invoice_payments', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->decimal('price', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'bill_payments', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->decimal('price', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'expenses', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'transactions', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
        }
        );

        Schema::table(
            'revenues', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
        }
        );
        Schema::table(
            'payments', function (Blueprint $table){
            $table->decimal('amount', 16, 2)->default('0.0')->change();
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
        //
    }
}
