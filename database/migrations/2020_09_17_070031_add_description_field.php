<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->text('description')->nullable()->after('price');
        }
        );

        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->text('description')->nullable()->after('price');
        }
        );

        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->text('description')->nullable()->after('price');
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
            'proposal_products', function (Blueprint $table){
            $table->dropColumn('description');
        }
        );

        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->dropColumn('description');
        }
        );

        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->dropColumn('description');
        }
        );
    }
}
