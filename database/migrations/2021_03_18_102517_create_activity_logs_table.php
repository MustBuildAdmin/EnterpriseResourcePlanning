<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('activity_logs')){
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->default(0);
                $table->integer('project_id')->default(0);
                $table->integer('task_id')->default(0);
                $table->integer('deal_id')->default(0);
                $table->string('log_type');
                $table->text('remark')->nullable();
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
        Schema::dropIfExists('activity_logs');
    }
}
