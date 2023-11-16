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
        Schema::table('custom_field_values', function (Blueprint $table) {
            $table->foreign(['field_id'])->references(['id'])->on('custom_fields')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_field_values', function (Blueprint $table) {
            $table->dropForeign('custom_field_values_field_id_foreign');
        });
    }
};
