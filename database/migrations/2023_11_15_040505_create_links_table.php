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
        Schema::create('links', function (Blueprint $table) {
            $table->integer('main_id', true);
            $table->integer('id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('instance_id', 300)->nullable();
            $table->text('type')->nullable();
            $table->integer('achive')->nullable()->default(0);
            $table->integer('source')->nullable();
            $table->integer('target')->nullable();
            $table->integer('lag')->nullable();
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
        Schema::dropIfExists('links');
    }
};
