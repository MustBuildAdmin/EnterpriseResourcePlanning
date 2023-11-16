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
        Schema::create('revision_task_progress', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('task_id')->nullable();
            $table->string('task_name', 450)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('instance_id', 500)->nullable();
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
        Schema::dropIfExists('revision_task_progress');
    }
};
