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
        Schema::create('upload_drawings_to_types', function (Blueprint $table) {
            $table->id();
            $table->integer('drawing_type');
            $table->integer('revisions');
            $table->string('status');
            $table->string('file_name');
            $table->string('drawing_path');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_drawings_to_types');
    }
};
