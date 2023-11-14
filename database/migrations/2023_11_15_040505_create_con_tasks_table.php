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
        Schema::create('con_tasks', function (Blueprint $table) {
            $table->integer('main_id', true);
            $table->integer('id');
            $table->text('text')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('users', 300)->nullable();
            $table->integer('duration')->nullable();
            $table->float('progress', 10, 0)->nullable();
            $table->string('start_date', 300)->nullable();
            $table->string('end_date', 300)->nullable();
            $table->string('predecessors', 300)->nullable();
            $table->string('instance_id', 300)->nullable();
            $table->integer('work_flag')->default(0);
            $table->integer('achive')->nullable()->default(0);
            $table->integer('parent')->nullable();
            $table->integer('sortorder')->default(0);
            $table->text('custom')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('float_val', 300)->nullable();
            $table->string('type', 300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('con_tasks');
    }
};
