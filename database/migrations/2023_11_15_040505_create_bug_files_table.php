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
        Schema::create('bug_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file');
            $table->string('name');
            $table->string('extension');
            $table->string('file_size');
            $table->integer('bug_id');
            $table->string('user_type');
            $table->integer('created_by');
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
        Schema::dropIfExists('bug_files');
    }
};
