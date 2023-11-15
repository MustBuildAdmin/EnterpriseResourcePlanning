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
        Schema::create('rfi_sub_status_save', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rfi_id')->nullable();
            $table->date('submit_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('remarks', 250)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->string('status_of_return', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfi_sub_status_save');
    }
};
