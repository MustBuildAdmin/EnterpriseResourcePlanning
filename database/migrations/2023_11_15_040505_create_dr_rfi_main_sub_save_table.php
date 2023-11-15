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
        Schema::create('dr_rfi_main_sub_save', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('contractor_name', 250)->nullable();
            $table->json('consulatant_data')->nullable();
            $table->string('reference_no', 250)->nullable();
            $table->date('requested_date')->nullable();
            $table->date('required_date')->nullable();
            $table->string('priority', 250)->nullable();
            $table->string('cost_impact', 250)->nullable();
            $table->string('time_impact', 250)->nullable();
            $table->text('description')->nullable();
            $table->string('select_the_consultants', 250)->nullable();
            $table->string('attachment_one', 240)->nullable();
            $table->text('attachment_one_path')->nullable();
            $table->json('date_of_replied_data')->nullable();
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
        Schema::dropIfExists('dr_rfi_main_sub_save');
    }
};
