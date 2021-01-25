<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaStkPushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stk_push', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('result_desc');
            $table->string('result_code');
            $table->string('merchant_request_id');
            $table->string('checkout_request_id');
            $table->string('amount');
            $table->string('mpesa_receipt_number');
            $table->string('balance');
            $table->string('b2c_utility_account_available_funds');
            $table->string('transaction_date');
            $table->string('phone_number');
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
        Schema::dropIfExists('mpesa_stk_push');
    }
}
