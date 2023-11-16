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
        Schema::table('user_deals', function (Blueprint $table) {
            $table->foreign(['deal_id'])->references(['id'])->on('deals')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_deals', function (Blueprint $table) {
            $table->dropForeign('user_deals_deal_id_foreign');
            $table->dropForeign('user_deals_user_id_foreign');
        });
    }
};
