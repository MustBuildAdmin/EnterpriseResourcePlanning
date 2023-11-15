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
        Schema::create('dairy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('file_name', 250)->nullable();
            $table->string('file_path', 250)->nullable();
            $table->json('diary_data');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dairy');
    }
};
