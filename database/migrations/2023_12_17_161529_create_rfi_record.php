<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rfi_record', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('responding_party_type');
            $table->integer('responder_id');
            $table->string('rfi_dependency');
            $table->string('rfi_dependency_values');
            $table->integer('time_impact')->nullable();
            $table->integer('cost_impact')->nullable();
            $table->dateTime('submission_date');
            $table->integer('rfi_priority');
            $table->string('description')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfi_record');
    }
};
