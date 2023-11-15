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
        Schema::create('dr_consultant_directions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('issued_by', 200)->nullable();
            $table->string('issued_date', 100)->nullable();
            $table->string('ad_ae_ref', 200)->nullable();
            $table->text('ad_ae_decs')->nullable();
            $table->string('attach_file_name', 200)->nullable();
            $table->text('file_path')->nullable();
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
        Schema::dropIfExists('dr_consultant_directions');
    }
};
