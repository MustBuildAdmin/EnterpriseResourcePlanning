<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledToJobOnBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_on_boards', function (Blueprint $table) {
            $table->string('job_type')->nullable()->after('convert_to_employee');
            $table->integer('days_of_week')->nullable()->after('convert_to_employee');
            $table->integer('salary')->nullable()->after('convert_to_employee');
            $table->string('salary_type')->nullable()->after('convert_to_employee');
            $table->string('salary_duration')->nullable()->after('convert_to_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_on_boards', function (Blueprint $table) {
            //
        });
    }
}
