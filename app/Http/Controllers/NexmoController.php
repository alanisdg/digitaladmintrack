<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use Auth;
use DB; 
use Carbon\Carbon;
use Nexmo;

class NexmoController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    { 
        $number = request()->get('number');
        $code = request()->get('code');

        $auth_basic = base64_encode("nestor.sandoval@digitaladmintrack.com:1200Mics");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.labsmobile.com/json/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"message":"'.$code.'", "tpoa":"Sender","recipient":[{"msisdn":"'.$number.'"}]}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic ".$auth_basic,
    "Cache-Control: no-cache",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return response()->json($response);
}


       
      
          
 
    }

    public function test(){


        $auth_basic = base64_encode("nestor.sandoval@digitaladmintrack.com:1200Mics");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.labsmobile.com/json/balance",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic ".$auth_basic,
    "Cache-Control: no-cache",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  dd($response);
}


        $test = Nexmo::message()->send([
            'to' => '528126296911',
            'from' => 'NEXMO SMS',
            'text' => '!R3,44,50'
        ]);

        dd($test);
    }


}
/*
curl -X POST  https://rest.nexmo.com/sms/json \
-d api_key=53d286f6 \
-d api_secret=ff9c473cf0261641 \
-d to=528126296911 \
-d from="NEXMO" \
-d text="Hello from Nexmo"

curl -X POST  https://rest.nexmo.com/sms/json \
-d api_key=53d286f6 \
-d api_secret=ff9c473cf0261641 \
-d to=345901008178179 \
-d from="NEXMO" \
-d text="!R3,44,50"
*/