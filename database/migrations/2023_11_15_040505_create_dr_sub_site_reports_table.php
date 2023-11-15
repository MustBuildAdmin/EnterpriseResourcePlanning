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
        Schema::create('dr_sub_site_reports', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('site_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('type', 250)->nullable();
            $table->string('position_name', 250)->nullable();
            $table->string('no_of_persons', 250)->nullable();
            $table->string('option_method', 250)->nullable();
            $table->string('hours', 250)->nullable();
            $table->string('total_hours', 250)->nullable();
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
        Schema::dropIfExists('dr_sub_site_reports');
    }
};
