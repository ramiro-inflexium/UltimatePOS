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
            $table->string('transaction_type')->nullable();
            $table->string('trans_id')->nullable();
            $table->string('trans_time')->nullable();
            $table->string('trans_amount')->nullable();
            $table->string('business_short_code')->nullable();
            $table->string('bill_ref_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('org_account_balance')->nullable();
            $table->string('third_party_trans_id')->nullable();
            $table->string('msisdn')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
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
