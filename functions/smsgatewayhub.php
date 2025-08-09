<?php

$api = "DZ12SO2o50KUswAKsgeacQ";
$sender = "HLDYHC";

function sendsms($phone, $message){
    global $api;
    global $sender;
    
    $msg = urlencode($message);
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://push.smsc.co.in/api/mt/SendSMS?APIKey=$api&senderid=$sender&channel=Trans&DCS=0&flashsms=0&number=$phone&text=$msg&route=47&DLTTemplateId=1707169667909518210&PEID=1701169660376406529",
      CURLOPT_SSL_VERIFYPEER => 0
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    return $err;
}

function checkBalance(){
    global $api;
    
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "login.smsgatewayhub.com/api/mt/GetBalance?APIKey=$api",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,	
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$arr = json_decode($response, "true");
return $arr['Balance'];

}

?>

