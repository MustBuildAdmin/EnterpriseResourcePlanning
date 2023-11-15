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
        Schema::create('procurement_material_submission', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('procurement_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('submission_date', 200)->nullable();
            $table->string('actual_reply_date', 200)->nullable();
            $table->integer('no_of_submission')->nullable();
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
        Schema::dropIfExists('procurement_material_submission');
    }
};
