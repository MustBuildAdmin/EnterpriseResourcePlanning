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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('report_to', 300)->nullable();
            $table->time('report_time')->nullable();
            $table->string('project_image')->nullable();
            $table->integer('budget')->nullable();
            $table->integer('client_id');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('estimated_hrs')->nullable();
            $table->string('estimated_days', 500)->nullable();
            $table->string('non_working_days', 600)->nullable();
            $table->integer('holidays')->nullable()->default(0);
            $table->longText('project_json')->nullable();
            $table->string('instance_id', 300)->nullable();
            $table->text('tags')->nullable();
            $table->integer('freeze_status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->string('country', 200)->nullable();
            $table->string('state', 200)->nullable();
            $table->string('city', 300)->nullable();
            $table->string('zipcode', 100)->nullable();
            $table->string('latitude', 300)->nullable();
            $table->string('longitude', 300)->nullable();
            $table->text('boq_file_path')->nullable();
            $table->string('boq_filename', 300)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
