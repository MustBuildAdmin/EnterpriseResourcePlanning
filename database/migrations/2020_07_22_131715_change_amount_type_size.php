<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAmountTypeSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'goals', function (Blueprint $table){
            $table->float('amount', 25, 2)->default(0.00)->change();
        }
        );

        Schema::table(
            'revenues', function (Blueprint $table){
            $table->float('amount', 25, 2)->default(0.00)->change();
        }
        );

        Schema::table(
            'payments', function (Blueprint $table){
            $table->float('amount', 25, 2)->default(0.00)->change();
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
        Schema::table(
            'goals', function (Blueprint $table){
            $table->dropColumn('amount');
        }
        );

        Schema::table(
            'revenues', function (Blueprint $table){
            $table->dropColumn('amount');
        }
        );

        Schema::table(
            'payments', function (Blueprint $table){
            $table->dropColumn('amount');
        }
        );

    }
}
