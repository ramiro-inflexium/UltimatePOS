<?php


namespace App\Misc\Payment\Mpesa;


class Simulator extends Validator
{

    private $command_id = 'CustomerPayBillOnline';
    private $amount = null;
    private $bill_ref_no = null;
    private $short_code = null;
    private $msisdn = null;

    protected $default_endpoints = [
        'live' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate',
        'sandbox' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate'
    ];


    public function  simulate(){
        $env = env('MPESA_ENV', 'sandbox');

        try {
            $this->validateEndpoints($env);
            $token = (new TokenGenerator())->generatetoken($env);
        } catch (\ErrorException $e){
            throw new \ErrorException($e->getMessage());
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token));

        $curl_post_data = array(
            'ShortCode' => $this->short_code,
            'CommandID' => $this->command_id,
            'Amount' => $this->amount,
            'Msisdn' => $this->msisdn,
            'BillRefNumber' => $this->bill_ref_no
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);

        return curl_exec($curl);
    }

    /**
     * @param null $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param null $bill_ref_no
     * @return $this
     */
    public function setBillRefNo($bill_ref_no)
    {
        $this->bill_ref_no = $bill_ref_no;
        return $this;
    }

    /**
     * @param null $msisdn
     * @return $this
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
        return $this;
    }

    /**
     * @param string $command_id
     * @return $this
     */
    public function setCommandId(string $command_id)
    {
        $this->command_id = $command_id;
        return $this;
    }

    /**
     * @param null $short_code
     * @return $this
     */
    public function setShortCode($short_code)
    {
        $this->short_code = $short_code;
        return $this;
    }

}