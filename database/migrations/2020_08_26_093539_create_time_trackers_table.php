<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'time_trackers', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('project_id')->nullable();
            $table->integer('task_id')->nullable();
            $table->text('tag_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('is_billable')->default(0);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('total_time')->default(0);
            $table->string('is_active')->default(1);
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
        Schema::dropIfExists('time_trackers');
    }
}
