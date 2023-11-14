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
        Schema::create('task_progress', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('task_id');
            $table->string('assign_to', 200)->nullable();
            $table->string('percentage', 100);
            $table->text('date_status')->nullable();
            $table->string('description', 400);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->text('instance_id')->nullable();
            $table->string('file_id', 250)->nullable();
            $table->string('record_date', 305)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_progress');
    }
};
