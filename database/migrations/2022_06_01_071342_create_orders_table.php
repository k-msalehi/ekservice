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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->foreignId('user_id')->constrained();
            $table->string('device_brand');
            $table->string('device_type');
            $table->string('device_model');
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('province_id');
            $table->string('city_id');
            $table->string('address');
            $table->char('national_id',10);
            $table->string('lon')->default(null);
            $table->string('lat')->default(null);
            $table->string('user_note',512);
            $table->string('admin_note',512)->nullable()->default(null);
            $table->unsignedInteger('rough_price')->nullable()->default(null);
            $table->unsignedInteger('requested_price')->nullable()->default(null);
            $table->unsignedInteger('paid_price')->nullable()->default(null);
            $table->unsignedInteger('final_price')->nullable()->default(null);
            $table->tinyInteger('status')->default();
            $table->string('delivery_code')->nullable()->default(null);
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
        Schema::dropIfExists('orders');
    }
};
