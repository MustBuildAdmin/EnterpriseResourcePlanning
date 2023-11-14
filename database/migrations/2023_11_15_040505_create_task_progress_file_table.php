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
        Schema::create('task_progress_file', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('task_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('filename', 250)->nullable();
            $table->text('file_path')->nullable();
            $table->string('instance_id', 300)->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_progress_file');
    }
};
