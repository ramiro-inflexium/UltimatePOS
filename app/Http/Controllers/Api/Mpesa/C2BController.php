<?php

namespace App\Http\Controllers\Api\Mpesa;

use App\Mpesa\MpesaC2b;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C2BController extends Controller
{
    protected $result_desc = null;
    protected $result_code = 1;

    public function confirmTrx(Request $request){
        $env = env('MPESA_ENVIRONMENT', 'sandbox');
        $confirmation_key = config("misc.mpesa.c2b.{$env}.confirmation_key");
        $short_code = config("misc.mpesa.c2b.{$env}.short_code");

        if ($request->confirmation_key != $confirmation_key){
            $this->result_desc = 'Confirmation key mismatch';
        }

        if ($request->BusinessShortCode != $short_code){
            $this->result_desc = 'Short Code mismatch';
        }

        // no error, change to success
        if (!$this->result_desc){

            $data = [
                 'transaction_type' => $request->transactionType,
                 'trans_id' => $request->transID,
                 'trans_time' => $request->transTime,
                 'trans_amount' => $request->transAmount,
                 'business_short_code' => $request->businessShortCode,
                 'bill_ref_number' => $request->billRefNumber,
                 'invoice_number' => $request->invoiceNumber,
                 'org_account_balance' => $request->orgAccountBalance,
                 'third_party_trans_id' => $request->thirdPartyTransID,
                 'msisdn' => $request->MSISDN,
                 'first_name' => $request->firstName,
                 'middle_name' => $request->lastName,
                 'last_name' => $request->middleName,
            ];



            MpesaC2b::create($data);

            $this->result_desc = 'Transaction saved successfully';
            $this->result_code = 0;

        }

        return response()->json([
            'ResultDesc' => $this->result_desc,
            'ResultCode' => $this->result_code
        ]);



    }

    public function validateTrx(){

    }
}
