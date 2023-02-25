<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('project_tasks')){
            Schema::create('project_tasks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('estimated_hrs')->default(0);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('priority', 50)->default('medium');
                $table->string('priority_color', 50)->nullable();
                $table->text('assign_to')->nullable();
                $table->integer('project_id')->default(0);
                $table->integer('milestone_id')->default(0);
                $table->integer('stage_id')->default(0);
                $table->integer('order')->default(0);
                $table->integer('created_by')->default(0);
                $table->integer('is_favourite')->default(0);
                $table->integer('is_complete')->default(0);
                $table->date('marked_at')->nullable();
                $table->string('progress', 5)->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_tasks');
    }
}
