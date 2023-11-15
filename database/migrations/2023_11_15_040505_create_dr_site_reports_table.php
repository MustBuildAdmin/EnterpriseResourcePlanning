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
        Schema::create('dr_site_reports', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('contractor_name', 250)->nullable();
            $table->date('con_date')->nullable();
            $table->string('site_conditions', 250)->nullable();
            $table->text('weather')->nullable();
            $table->string('con_day', 250)->nullable();
            $table->string('temperature', 250)->nullable();
            $table->string('min_input', 250)->nullable();
            $table->string('degree', 250)->nullable();
            $table->text('attachements')->nullable();
            $table->text('remarks')->nullable();
            $table->string('prepared_by', 250)->nullable();
            $table->string('title', 250)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->string('total_in_power_one', 250)->nullable();
            $table->string('total_di_power_one', 250)->nullable();
            $table->string('total_con_power_one', 250)->nullable();
            $table->string('total_in_power_two', 250)->nullable();
            $table->string('total_di_power_two', 250)->nullable();
            $table->string('total_con_power_two', 250)->nullable();
            $table->string('file_id', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dr_site_reports');
    }
};
