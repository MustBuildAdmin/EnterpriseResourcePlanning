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
        Schema::create('project_specification', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('reference_no', 250)->nullable();
            $table->string('description', 250)->nullable();
            $table->string('location', 250)->nullable();
            $table->string('drawing_reference', 250)->nullable();
            $table->string('remarks', 250)->nullable();
            $table->string('attachment_file_name', 250)->nullable();
            $table->text('attachment_file_location')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_specification');
    }
};
