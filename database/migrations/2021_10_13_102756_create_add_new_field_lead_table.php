<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddNewFieldLeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'leads', function (Blueprint $table){
            $table->string('phone')->nullable()->after('email');
        }
        );
        Schema::table(
            'deals', function (Blueprint $table){
            $table->string('phone')->nullable()->after('name');
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
        Schema::dropIfExists('  add_new_field_lead');
    }
}
