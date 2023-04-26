<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->unique();
            $table->float('price')->default(0);
            $table->string('duration',100);
            $table->integer('max_users')->default(0);
            $table->integer('max_customers')->default(0);
            $table->integer('max_venders')->default(0);
            $table->integer('max_clients')->default(0);
            $table->integer('crm')->default(0);
            $table->integer('hrm')->default(0);
            $table->integer('account')->default(0);
            $table->integer('project')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('plans');
    }
}
