<?php

namespace App\Traits;
use DB;
use Mail;
use App\Users;
use Carbon\Carbon;

trait Translate {
 public function translate() {
 $curl = curl_init();
$string1= "cream";
$string2="hello";
  curl_setopt_array($curl, [
	CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "q=".$string1."&q=".$string2."&target=hi",
	CURLOPT_HTTPHEADER => [
		"accept-encoding: application/gzip",
		"content-type: application/x-www-form-urlencoded",
		"x-rapidapi-host: google-translate1.p.rapidapi.com",
		"x-rapidapi-key: 735f8368dcmsh25dbf7e5f43dfb0p190381jsna96e6ab0ca2e"
	],
]);

$response = curl_exec($curl);
$value2 = json_decode($response);

$test= $value2->data->translations[1]->translatedText;
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $test;
}
    }
    
}
