<?php

namespace App\Mpesa;

use Illuminate\Database\Eloquent\Model;

class MpesaC2b extends Model
{
    protected $table = 'mpesa_c2b';

    protected $fillable = [
        'transaction_type',
        'trans_id',
        'trans_time',
        'trans_amount',
        'business_short_code',
        'bill_ref_number',
        'invoice_number',
        'org_account_balance',
        'third_party_trans_id',
        'msisdn',
        'first_name',
        'middle_name',
        'last_name'
    ];
}
