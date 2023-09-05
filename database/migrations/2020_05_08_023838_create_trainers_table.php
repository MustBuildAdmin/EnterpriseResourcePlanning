<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'trainers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('branch');
                $table->string('firstname');
                $table->string('lastname');
                $table->string('contact');
                $table->string('email');
                $table->text('address')->nullable();
                $table->text('expertise')->nullable();
                $table->integer('created_by');
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
        Schema::dropIfExists('trainers');
    }
}
