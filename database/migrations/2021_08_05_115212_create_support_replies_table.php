<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'support_replies', function (Blueprint $table){
            $table->id();
            $table->integer('support_id');
            $table->integer('user')->default(0);
            $table->text('description')->nullable();
            $table->integer('created_by');
            $table->integer('is_read')->default('0');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_replies');
    }
}
