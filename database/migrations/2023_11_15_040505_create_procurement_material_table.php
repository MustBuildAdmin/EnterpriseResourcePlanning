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
        Schema::create('procurement_material', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ram_ref_no', 200)->nullable();
            $table->string('location', 200)->nullable();
            $table->string('supplier_name', 200)->nullable();
            $table->string('contact_person', 200)->nullable();
            $table->string('mobile_hp_no', 200)->nullable();
            $table->string('tel', 200)->nullable();
            $table->string('fax', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('lead_time', 200)->nullable();
            $table->string('target_delivery_date', 200)->nullable();
            $table->string('target_approval_date', 200)->nullable();
            $table->string('status', 200)->nullable();
            $table->text('remarks')->nullable();
            $table->string('filename', 200)->nullable();
            $table->text('file_location')->nullable();
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
        Schema::dropIfExists('procurement_material');
    }
};
