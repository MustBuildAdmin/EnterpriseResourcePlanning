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
        Schema::table('deal_calls', function (Blueprint $table) {
            $table->foreign(['deal_id'])->references(['id'])->on('deals')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_calls', function (Blueprint $table) {
            $table->dropForeign('deal_calls_deal_id_foreign');
        });
    }
};
