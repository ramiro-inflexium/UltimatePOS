<?php

namespace App\Http\Controllers\Api\Mpesa;

use App\Misc\Payment\Mpesa\Simulator;
use App\Mpesa\MpesaC2b;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C2BController extends Controller
{
    protected $result_desc = null;
    protected $result_code = 1;

    public function confirmTrx(Request $request){
        $env = env('MPESA_ENV', 'sandbox');
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
                 'transaction_type' => $request->TransactionType,
                 'trans_id' => $request->TransID,
                 'trans_time' => $request->TransTime,
                 'trans_amount' => $request->TransAmount,
                 'business_short_code' => $request->BusinessShortCode,
                 'bill_ref_number' => $request->BillRefNumber,
                 'invoice_number' => $request->InvoiceNumber,
                 'org_account_balance' => $request->OrgAccountBalance,
                 'third_party_trans_id' => $request->ThirdPartyTransID,
                 'msisdn' => $request->MSISDN,
                 'first_name' => $request->FirstName,
                 'middle_name' => $request->LastName,
                 'last_name' => $request->MiddleName,
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

    /**
     * @param Request $request
     * @return bool|string|void
     */
    public function simulate(Request $request){
        try {
            $feedback = (new Simulator())->setShortCode($request->short_code)
                ->setAmount($request->amount)
                ->setBillRefNo($request->bill_ref_no)
                ->setMsisdn($request->msisdn)
                ->simulate();
        } catch (\ErrorException $e){
            return $e->getMessage();
        }
        return $feedback;
    }
}
