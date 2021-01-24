<?php

namespace App\Http\Controllers;

use Mpesa;
use Illuminate\Http\Request;

class MpesaController extends Controller
{

    public function index()
    {
        $registerUrlsResponse=Mpesa::c2bRegisterUrls();

        $simulateResponse=Mpesa::simulateC2B(100, "254714522718", "Testing");

        dd($simulateResponse);
    }

    public function mpesavalidate()
    {

    }

    public function simulateC2B($amount,$phone)
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken())); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ShortCode' => '600000',
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'Msisdn' => $phone,
            'BillRefNumber' => 'test'
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        print_r($curl_response);

        return $curl_response;
    }

    public function registerURL()
    {
        /* This two files are provided in the project. */
        $confirmationUrl = 'http://tambuabiz.zuca.co.ke/safdaraja/confirmation_url.php'; // path to your confirmation url. can be IP address that is publicly accessible or a url
        $validationUrl = 'http://tambuabiz.zuca.co.ke/safdaraja/validation_url.php'; // path to your validation url. can be IP address that is publicly accessible or a url
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken())); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ShortCode' => '600000',
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $confirmationUrl,
            'ValidationURL' => $validationUrl
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
//        print_r($curl_response);

        return $curl_response;
    }

    public function generatetoken()
    {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode('BDDcJwinys9iNmXIt5jI97lwwUuayURj:asDCvkNAyMKdqaO4');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);
        $json_decode = json_decode($curl_response);
        $access_token = $json_decode->access_token;

        return $access_token;
    }

    public function generatetokenstk()
    {
        # access token
        $consumerKey = 'BDDcJwinys9iNmXIt5jI97lwwUuayURj'; //Fill with your app Consumer Key
        $consumerSecret = 'asDCvkNAyMKdqaO4'; // Fill with your app Secret

        $headers = ['Content-Type:application/json; charset=utf8'];

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);

        $access_token = $result->access_token;
        //echo $access_token;

        return $access_token;
    }

    public function stk_initiate($amount = null,$tel = null)
    {
        date_default_timezone_set('Africa/Nairobi');

        $access_token = $this->generatetokenstk();

        # define the variales
        # provide the following details, this part is found on your test credentials on the developer account
        $BusinessShortCode = '174379';
        $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

        /*
          This are your info, for
          $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
          $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
          TransactionDesc can be anything, probably a better description of or the transaction
          $Amount this is the total invoiced amount, Any amount here will be
          actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction.
          for developer/test accounts, this money will be reversed automatically by midnight.
        */

        $PartyA = $tel; // This is your phone number, 254796018326 Gerard Kandaa Hurray
        $AccountReference = 'Zuca Test Hurray';
        $TransactionDesc = 'pay bill';
        $Amount = $amount;

        # Get the timestamp, format YYYYmmddhms -> 20181004151020
        $Timestamp = date('YmdHis');

        # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
        $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

        # header for access token
        $headers = ['Content-Type:application/json; charset=utf8'];

        # M-PESA endpoint urls
        $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        # callback url
//        $CallBackURL = redirect('callback_url')->getTargetUrl();
        $CallBackURL = 'http://tambuabiz.zuca.co.ke/stk_push/callback_url.php';
//        $CallBackURL = 'http://tambuabiz.zuca.co.ke/callback_url';

        $access_token = $this->generatetokenstk();

        # header for stk push
        $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

        # initiating the transaction
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $initiate_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
//        print_r($curl_response);

        return $curl_response;
    }

    public function callback_urll(Request $request){
        $url = 'http://tambuabiz.zuca.co.ke/stk_push/callback_url.php';
        return $url;
        $stkCallbackResponse = file_get_contents('php://input');

        //Log to file
        $logFile = "stkPushCallbackResponse.json";
        $log = fopen($logFile, "a");
        fwrite($log, $stkCallbackResponse);
        fclose($log);

        $object = json_decode($stkCallbackResponse);
        // var_dump($object);
        $data = $object->Body->stkCallback;
        $response_data = [
            'Amount' => 0,
            'MpesaReceiptNumber' => 0,
            'TransactionDate' => 0,
            'PhoneNumber' => 0
        ];
        if ($data->ResultCode == 0) {
            //sucess
            $_payload = $data->CallbackMetadata->Item;
            foreach ($_payload as $callback) {
                $response_data[$callback->Name] = @$callback->Value;
            }

            $sos = Carbon::now();
            $eos = Carbon::now();
            $data = [
                'company_id' => 9,
                'mop' => 'Mpesa',
                'sos' => $sos,
                'eos' => $eos,
                'amount' => 13,
                'balance' => 13,
                'mos' => 2,
                'code' => '887878',
            ];
            $create = Payments::create($data);

        } else {
            //failed
            //insert to DB
            var_dump($object);
        }
    }

    public function callback_url(){

        $path = "stk_push";

        $latest_ctime = 0;
        $latest_filename = '';

        $d = dir($path);
        while (false !== ($entry = $d->read())) {
            $filepath = "{$path}/{$entry}";
            // could do also other checks than just checking whether the entry is a file
            if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
                $latest_ctime = filectime($filepath);
                $latest_filename = $entry;
            }
        }

        $file = File::get(public_path('stk_push/'.$latest_filename));
//        $response_data = json_decode($file, true);
//        return $newest_file;
        dd($file);
    }
    public function check_if_file_exist($response_file)
    {

        $start = microtime(true);
        $limit = 55; // Seconds
        $file = false;
//        echo "Script began: " . date("d-m-Y h:i:s") . "<br>";
        do {
            if (file_exists($response_file)) {
//                echo "The file was found: " . date("d-m-Y h:i:s") . "<br>";
                $file = true;
                break;
            }
            if (microtime(true) - $start >= $limit) {
                break;
            }
        } while(true);

        return $file;
    }

}
