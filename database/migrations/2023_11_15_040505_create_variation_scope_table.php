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
        Schema::create('variation_scope', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->json('data')->nullable();
            $table->string('attachment_file', 250)->nullable();
            $table->text('attachment_file_path')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('variation_scope');
    }
};
