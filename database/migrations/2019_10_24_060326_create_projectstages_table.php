<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectstagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'projectstages', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('color', 15)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('order')->default(0);;
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
        Schema::dropIfExists('projectstages');
    }
}
