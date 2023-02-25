<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'deal_emails', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deal_id');
            $table->string('to');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
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
        Schema::dropIfExists('deal_emails');
    }
}
