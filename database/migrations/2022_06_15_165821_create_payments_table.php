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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedInteger('amount');
            $table->string('ref_id')->default(''); // bank reference id for payment
            $table->string('bank_sale_order_id')->default('');; // bank sale order id (for bank payment)
            $table->string('bank_sale_refrence_id')->default('');; // bank sale reference id (transaction id)
            $table->unsignedTinyInteger('status')->default(config('constants.payment.status.pending'));
            $table->string('note')->default('');

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
        Schema::dropIfExists('payments');
    }
};
