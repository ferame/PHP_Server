<?php
$isTweet=$_GET['tweet'];
$isTwilio=$_GET['twilio'];
$isWeather=$_GET['weather'];
$isStudent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postRez = file_get_contents('php://input');
    if (strpos($postRez, "Crd:") !== false){
        $isStudent = true;
    }else{
        echo "Non-existent student";
    }
}

use Twilio\Rest\Client;
require_once('TwitterAPIExchange.php');

if ($isTweet) {
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
    'oauth_access_token' => "4527318323-QgDLuD3iPMTlvYTTYSrroMigkmwH97IcXcYidvx",
    'oauth_access_token_secret' => "PLhGHAR1s9GHwmBSBqHYPJI5tMM1NmbUd4vAhvHC6ks8l",
    'consumer_key' => "660PKn9qD6wnTyARbolTUKMEJ",
    'consumer_secret' => "4ooMzBfjIFKbGPdrIVY6dS4mWm0loDsET0wnkW8YtQQ0WEcG6C"
    );
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    $requestMethod = "GET";
    $user = "Dziastis";
    $count = 1;
    $getfield = "?screen_name=$user&count=$count";
    $twitter = new TwitterAPIExchange($settings);
    $json = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    $tweets = json_decode($json, true);

    echo $tweets[0]['text'];
}elseif ($isTwilio){
    // Required if your environment does not handle autoloading
    require __DIR__ . '/vendor/autoload.php';

    // Use the REST API Client to make requests to the Twilio REST API


    // Your Account SID and Auth Token from twilio.com/console
    $sid = 'AC13e4b5e82ecd12c5c1a60a523c0843dd';
    $token = '93d910e4ff352ca25a142565e90d2a63';
    $client = new Client($sid, $token);

    // Use the client to do fun stuff like send text messages!
    $client->messages->create(
    // the number you'd like to send the message to
        '+447547246501',
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => '+447403930290',
            // the body of the text message you'd like to send
            'body' => 'Hello from NodeMCU!'
        )
    );
    echo "SMS sent";
}elseif ($isWeather){
    $json = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?id=3333229&appid=1122e950271e86bfbffb6a2378ff6943&units=metric");
    $weatherInfo = json_decode($json, true);

    $time_prediction = $weatherInfo['list'][0]['dt_txt'];
    $time_prediction = date_create($time_prediction);
    $time_prediction = date_format($time_prediction,"Y-m-d D G:i");
   
    $main_weather = $weatherInfo['list'][0]['weather'][0]['main'];
    
    $description_weather = $weatherInfo['list'][0]['weather'][0]['description'];
    
    $temperature = $weatherInfo['list'][0]['main']['temp'];
    $temperatureDecimal = number_format((float)floatval($temperature), 1, '.', '');

    echo($time_prediction . "#" . $main_weather . " (" . ucfirst($description_weather) . ")#" . $temperatureDecimal . " Celsius" . "#Edinburgh");
}elseif ($isStudent){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://tweety.gq/ArrestDB/students",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    echo $response;
    }
    //$data = GET http://api.example.com/customers/;
}
