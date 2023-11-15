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
        Schema::create('dr_rfi_sub_save', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rfi_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('multi_total_count')->nullable();
            $table->string('name_of_consultant', 250)->nullable();
            $table->date('replied_date')->nullable();
            $table->string('status', 250)->nullable();
            $table->text('remarks')->nullable();
            $table->string('attachments_two', 250)->nullable();
            $table->text('attachments_two_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dr_rfi_sub_save');
    }
};
