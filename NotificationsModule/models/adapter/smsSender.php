<?php
use Models\Isms;
// require_once '/../vendor/autoload.php';
// require_once './Isms.php';

require_once __DIR__ .'/../adapter/Isms.php';
class smsSender implements Isms{

    public function send_sms($event_name,$event_date){

    // $sid = '';
    // $token = '';
    // $twilio_number = '+1620XXXXX';

    $to_number = '+XXXXXXXXXX';

    $message_body = "New event ({$event_name}) on {$event_date} 👀 Check it out now on our website";
    // Simulate SMS sending
    echo "SMS sent to {$to_number}: {$message_body}" . PHP_EOL;

}}
//    try {
//        $client = new \Twilio\Rest\Client($sid, $token);
//
//        $message = $client->messages->create(
//            $to_number,
//            [
//                'from' => $twilio_number,
//                'body' => $message_body
//            ]
//        );
//
//    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
//    }
//    }

