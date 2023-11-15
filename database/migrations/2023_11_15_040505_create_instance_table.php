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
        Schema::create('instance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('instance', 300)->nullable();
            $table->string('start_date', 100)->nullable();
            $table->string('end_date', 100)->nullable();
            $table->string('percentage', 100)->nullable();
            $table->integer('freeze_status')->nullable()->default(0);
            $table->integer('achive')->default(0);
            $table->integer('project_id')->nullable();
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
        Schema::dropIfExists('instance');
    }
};
