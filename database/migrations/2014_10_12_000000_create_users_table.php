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
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->string('tel')->unique();
            $table->char('national_id')->unique()->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('otp')->nullable()->default(null);
            $table->unsignedInteger('otp_expire')->nullable()->default(null);
            $table->unsignedTinyInteger('role')->default(config('constants.roles.customer'));
            $table->rememberToken();
            $table->unsignedTinyInteger('status')->default(config('constants.statuses.active'));
            $table->string('hash')->nullable()->default(null);
            $table->timestamps();
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
