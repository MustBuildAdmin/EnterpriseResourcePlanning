<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('expenses')){
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->date('date')->nullable();
                $table->string('description')->nullable();
                $table->integer('amount')->default(0);
                $table->string('attachment')->nullable();
                $table->integer('project_id')->default(0);
                $table->integer('task_id')->default(0);
                $table->integer('created_by')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
