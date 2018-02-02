<?php
$isTweet=$_GET['tweet'];
$isTwillio=$_GET['twillio'];

use Twilio\Rest\Client;
if ($isTweet) {
    $client = new http\Client;
    $request = new http\Client\Request;

    $request->setRequestUrl('https://api.twitter.com/1.1/statuses/user_timeline.json');
    $request->setRequestMethod('GET');
    $request->setQuery(new http\QueryString(array(
        'count' => '1',
        'screen_name' => 'Dziastis'
    )));

    $request->setHeaders(array(
  'authorization' => 'OAuth oauth_consumer_key="660PKn9qD6wnTyARbolTUKMEJ", oauth_nonce="e8TStetU54nzI4d3THlCXq60hjSJpVEI", oauth_signature="UNleuCMT6k9Yy6DdmAasdntSyyU%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1517580449", oauth_token="4527318323-QgDLuD3iPMTlvYTTYSrroMigkmwH97IcXcYidvx", oauth_version="1.0"'
));


    $client->setCookies(array(
        'guest_id' => 'v1%3A151622209740528028',
        'lang' => 'en',
        'personalization_id' => '"v1_C135iIQD0UsAYB+o4gxOaw=="'
    ));

    $client->enqueue($request)->send();
    $response = $client->getResponse();
//echo "1";
    $json = $response->getBody();
//echo $json;
    $tweets = json_decode($json, true);

    echo $tweets[0]['text'];
}elseif ($isTwillio){
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

}
