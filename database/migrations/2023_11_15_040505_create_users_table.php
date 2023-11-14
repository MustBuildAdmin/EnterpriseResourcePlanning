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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('lname')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 16);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->string('gender', 255)->nullable();
            $table->integer('plan')->nullable();
            $table->date('plan_expire_date')->nullable();
            $table->integer('requested_plan')->default(0);
            $table->string('type', 100)->nullable();
            $table->string('avatar', 100)->nullable();
            $table->string('lang', 100)->nullable();
            $table->string('mode', 10)->default('light');
            $table->integer('created_by')->default(0);
            $table->integer('default_pipeline')->nullable();
            $table->integer('delete_status')->default(1);
            $table->integer('is_active')->default(1);
            $table->integer('verfiy_email')->nullable();
            $table->rememberToken();
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip', 255)->nullable();
            $table->text('address')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->integer('reporting_to')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_zip')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->text('shipping_address')->nullable();
            $table->integer('copy_status')->default(0);
            $table->string('company_name', 45)->nullable();
            $table->timestamps();
            $table->string('messenger_color')->default('#2180f3');
            $table->boolean('dark_mode')->default(false);
            $table->boolean('active_status')->default(false);
            $table->integer('company_type')->nullable();
            $table->text('color_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
