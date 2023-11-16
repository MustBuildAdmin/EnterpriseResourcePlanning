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
        Schema::table('user_leads', function (Blueprint $table) {
            $table->foreign(['lead_id'])->references(['id'])->on('leads')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
        Schema::table('user_leads', function (Blueprint $table) {
            $table->dropForeign('user_leads_lead_id_foreign');
            $table->dropForeign('user_leads_user_id_foreign');
        });
    }
};
