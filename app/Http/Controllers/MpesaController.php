<?php

namespace App\Http\Controllers;

use App\Misc\Payment\Mpesa\Registrar;
use App\Misc\Payment\Mpesa\TokenGenerator;
use Illuminate\Http\Request;

class MpesaController extends Controller
{

    public function index(){
        try {
            $env = 'sandbox';
            $config = config("misc.mpesa.c2b.{$env}");
            $token = (new TokenGenerator())->generatetoken($env);
            $confirmation_url = route('api.mpesa.c2b.confirm', $config['confirmation_key']);
            $validation_url = route('api.mpesa.c2b.validate', $config['validation_key']);
            $short_code = $config['short_code'];

//            dd($validation_url);

            $response = (new Registrar())->setShortCode($short_code)
                ->setValidationUrl($validation_url)
                ->setConfirmationUrl($confirmation_url)
                ->setToken($token)
                ->register($env);
//            dd('ll');
        } catch (\ErrorException $e){
            return $e->getMessage();
        }

        return $response;
    }

}
