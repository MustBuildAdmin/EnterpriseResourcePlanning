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
        Schema::create('dr_consultants_direction_multi', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('consultant_id')->nullable();
            $table->string('initiator_reference', 200)->nullable();
            $table->string('initiator_date', 200)->nullable();
            $table->string('initiator_file_name', 200)->nullable();
            $table->text('initiator_file_path')->nullable();
            $table->string('replier_reference', 200)->nullable();
            $table->string('replier_date', 200)->nullable();
            $table->string('replier_status', 200)->nullable();
            $table->text('replier_remark')->nullable();
            $table->string('replier_file_name', 200)->nullable();
            $table->text('replier_file_path')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dr_consultants_direction_multi');
    }
};
