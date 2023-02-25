<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'estimations', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estimation_id');
            $table->unsignedBigInteger('client_id');
            $table->string('status');
            $table->date('issue_date');
            $table->float('discount');
            $table->unsignedBigInteger('tax_id');
            $table->text('terms')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('estimations');
    }
}
