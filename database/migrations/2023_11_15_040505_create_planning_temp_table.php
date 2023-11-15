<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_temp', function (Blueprint $table) {
            $table->integer('idplanning_temp')->primary();
            $table->string('taskid', 45)->nullable();
            $table->longText('text')->nullable();
            $table->timestamp('start_date', 6)->nullable();
            $table->timestamp('end_date', 6)->nullable();
            $table->float('progess', 10, 0)->nullable();
            $table->float('duration', 10, 0)->nullable();
            $table->string('parent', 120)->nullable();
            $table->integer('isOpen')->nullable();
            $table->longText('predecessor')->nullable();
            $table->longText('successor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning_temp');
    }
};
