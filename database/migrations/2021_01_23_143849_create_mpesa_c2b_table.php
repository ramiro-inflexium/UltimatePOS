<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaC2bsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_c2b', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_type');
            $table->string('trans_id');
            $table->string('trans_time');
            $table->string('trans_amount');
            $table->string('business_shortCode');
            $table->string('billRef_number');
            $table->string('invoice_number');
            $table->string('orgAccount_balance');
            $table->string('third_party_trans_id');
            $table->string('msisdn');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
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
        Schema::dropIfExists('mpesa_c2bs');
    }
}
