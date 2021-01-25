<?php

namespace App\Misc\Payment\Mpesa;

class TokenGenerator extends Validator
{
    protected $default_endpoints = [
        'live' => 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
        'sandbox' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
    ];

    public function generatetoken(string $env)
    {
        $this->validateEndpoints($env);
        $consumer_key = config("misc.mpesa.c2b.{$env}.consumer_key");
        $consumer_secret = config("misc.mpesa.c2b.{$env}.consumer_secret");

        if (!$consumer_key){
            die("Please declare the consumer key");
        }
        if (!$consumer_secret){
            die("Please declare the consumer secret ");
        }
//        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);
        $json_decode = json_decode($curl_response);
        $access_token = $json_decode->access_token;

        return $access_token;
    }
}