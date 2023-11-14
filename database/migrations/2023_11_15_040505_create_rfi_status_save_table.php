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
        Schema::create('rfi_status_save', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('reference_no', 250)->nullable();
            $table->date('issue_date')->nullable();
            $table->string('description', 250)->nullable();
            $table->date('consultant_date1')->nullable();
            $table->date('consultant_date2')->nullable();
            $table->date('consultant_date3')->nullable();
            $table->date('consultant_date4')->nullable();
            $table->date('consultant_date5')->nullable();
            $table->date('consultant_date6')->nullable();
            $table->string('attachment_file', 250)->nullable();
            $table->string('rfi_status', 250)->nullable();
            $table->string('remark1', 250)->nullable();
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
        Schema::dropIfExists('rfi_status_save');
    }
};
