<?php
date_default_timezone_set('Europe/London');

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
    getTweet();
}
if ($isTwilio){
    echo("Twilio service is disabled. Project upgrades taking place - Justin");
    //sendTwilioMessage();
}
if ($isWeather){
    getWeather();
}

if ($isStudent){
    echo (checkTutorial($postRez));
}

function getTweet(){
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    /*$settings = array(
    'oauth_access_token' => "4527318323-QgDLuD3iPMTlvYTTYSrroMigkmwH97IcXcYidvx",
    'oauth_access_token_secret' => "PLhGHAR1s9GHwmBSBqHYPJI5tMM1NmbUd4vAhvHC6ks8l",
    'consumer_key' => "660PKn9qD6wnTyARbolTUKMEJ",
    'consumer_secret' => "4ooMzBfjIFKbGPdrIVY6dS4mWm0loDsET0wnkW8YtQQ0WEcG6C"
    );*/
    //echo("This was called");
    $settings = array(
        'oauth_access_token' => "990687770111827969-ogpTdmjcXrDlVF7JDzljOq5fZ5lLba3",
        'oauth_access_token_secret' => "EXnhLFzNdH6VoUSzj6PimE6tUHjB1THBMyhjzvpCuzYkT",
        'consumer_key' => "TJeoYqd2LBCPEl00S5lPX5scS",
        'consumer_secret' => "0ia80SAXNbrm8Xhn5MdFgBaZgTNNx4CAoDMANNwbbFB9C9bagT"
    );

    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    $requestMethod = "GET";
    $user = "prototypeED";
    $count = 1;
    $getfield = "?screen_name=$user&count=$count";
    $twitter = new TwitterAPIExchange($settings);
    $json = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    $tweets = json_decode($json, true);
    echo $tweets[0]['text'];
}

function sendTwilioMessage(){
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
        //'+447547246501',
        //'+447597290539',
        '+447460985636',
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => '+447403930290',
            // the body of the text message you'd like to send
            //'body' => 'Hello from NodeMCU!'
            'body' => 'Hi, this is a notification from the prototype!'
        )
    );

    echo "SMS notification to the professor - SENT";
}

function getWeather(){
    $json = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?id=3333229&appid=1122e950271e86bfbffb6a2378ff6943&units=metric");
    $weatherInfo = json_decode($json, true);

    $time_prediction = $weatherInfo['list'][0]['dt_txt'];
    $time_prediction = date_create($time_prediction);
    $time_prediction = date_format($time_prediction,"Y-m-d D G:i");
   
    $main_weather = $weatherInfo['list'][0]['weather'][0]['main'];
    
    $description_weather = $weatherInfo['list'][0]['weather'][0]['description'];
    
    $temperature = $weatherInfo['list'][0]['main']['temp'];
    $temperatureDecimal = number_format((float)floatval($temperature), 1, '.', '');

    echo($time_prediction . "#" . $main_weather . " (" . ucfirst($description_weather) . ")#" . $temperatureDecimal . " Celsius" . "#Edinburgh");
}

function checkTutorial($postRez){
    $processed = preg_replace('/\s+/', '', substr($postRez, 4));
    $RFID = substr($processed, 0, 8);
    $deviceID = substr($processed, 8);
    if (empty($deviceID)){
        return "Missing device ID";
    }

    $jsonResponseStudents = dbQueryRequest("/students/rfid/" . $RFID);

    $uniid = NULL;
    if (!empty($jsonResponseStudents)){
        $uniid = $jsonResponseStudents[0]["uniid"];
    } else {
        return "Database offline";
    }

    $jsonResponseTutorials = NULL;
    if (!empty($uniid)){
        $jsonResponseTutorials = dbQueryRequest("/tutorials/uniid/" . $uniid);
    }else{
        return "No student associated with this card";
    }
    
    if (!empty($jsonResponseTutorials)){
        return (checkCurrentTutorial($jsonResponseTutorials,$deviceID));
    }else{
        return "You have no tutorials assigned";
    }
}

function checkCurrentTutorial($tutorialsData, $deviceID){
    //$time = date("D G:i");
    //$timeTimestamp = strtotime($time);
    $timeTimestamp = strtotime("FRI 15:30");
    $supposedToGo = NULL;
    foreach($tutorialsData as $tutorial){
        $startTimestamp = strtotime($tutorial['start_time']);
        $endTimestamp = strtotime($tutorial['end_time']);
        if($timeTimestamp >= $startTimestamp && $endTimestamp > $timeTimestamp){
            if(strcmp($deviceID,$tutorial['device_id']) === 0){
                $strToReturn = $tutorial['course'] . " tutorial presence marked.";
                return $strToReturn;
            }else{
                $supposedToGo = "Wrong room, you have " . $tutorial['tutorial_id'] . " go to " . $tutorial['location'];
            }
        }
    }
    if(empty($supposedToGo)){
        return "You have no tutorial at this time, go home.";
    }else{
        return $supposedToGo;
    }
}

function dbQueryRequest($query){
    $curl = curl_init();
    $fullQuery = "https://tweety.gq/ArrestDB" . $query;

    curl_setopt_array($curl, array(
    //CURLOPT_URL => ("http://tweety.gq/ArrestDB/students/rfid/" . $processedRFID),
    CURLOPT_URL => $fullQuery,
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
        return NULL;
    } else {
        return json_decode($response,true);
    }
}
