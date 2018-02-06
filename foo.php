<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twitter.com/1.1/statuses/user_timeline.json?count=1&screen_name=Dziastis",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_COOKIE => "personalization_id=%22v1_C135iIQD0UsAYB%2Bo4gxOaw%3D%3D%22; lang=en; guest_id=v1%253A151622209740528028",
  CURLOPT_HTTPHEADER => array(
    "authorization: OAuth oauth_consumer_key="660PKn9qD6wnTyARbolTUKMEJ", oauth_nonce="LhGnT50pNhBSz8eUhVdTUuOvOVttUVK5", oauth_signature="Ymuxfvjo1QTL1FMflaQ1vH0hRo0%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1517686274", oauth_token="4527318323-QgDLuD3iPMTlvYTTYSrroMigkmwH97IcXcYidvx", oauth_version="1.0""
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
