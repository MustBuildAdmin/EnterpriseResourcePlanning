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
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->integer('meeting_id')->default(0);
            $table->integer('project_id')->default(0);
            $table->string('user_id')->nullable();
            $table->integer('client_id')->default(0);
            $table->string('password')->nullable();
            $table->timestamp('start_date')->useCurrent();
            $table->integer('duration')->default(0);
            $table->text('start_url')->nullable();
            $table->string('join_url')->nullable();
            $table->string('status')->nullable()->default('waiting');
            $table->integer('created_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
