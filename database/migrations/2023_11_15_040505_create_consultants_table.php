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
        Schema::create('consultants', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('gender', 255);
            $table->string('country', 255);
            $table->string('state', 255);
            $table->string('city', 255);
            $table->text('address');
            $table->string('zip', 255);
            $table->integer('created_by');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultants');
    }
};
