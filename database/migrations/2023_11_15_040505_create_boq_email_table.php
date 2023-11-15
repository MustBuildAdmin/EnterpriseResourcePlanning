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
        Schema::create('boq_email', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('project_id')->nullable();
            $table->string('project_name', 250)->nullable();
            $table->string('security_code', 250)->nullable();
            $table->string('code_expires_at', 250)->nullable();
            $table->string('sender', 300)->nullable();
            $table->string('receiver', 300)->nullable();
            $table->integer('status')->default(1);
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('boq_email');
    }
};
