<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'task_stages', function (Blueprint $table){
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('complete')->default(0);
            $table->unsignedBigInteger('project_id')->default(0);
            $table->string('color', 15)->nullable();
            $table->integer('order')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('task_stages');
    }
}
